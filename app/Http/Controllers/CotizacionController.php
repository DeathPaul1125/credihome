<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\CotizacionItem;
use App\Models\Cliente;
use App\Models\Receta;
use App\Models\Producto;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    public function index(Request $request)
    {
        $query = Cotizacion::with(['cliente', 'user'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_cotizacion', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $cotizaciones = $query->paginate(15);

        return view('cotizaciones.index', compact('cotizaciones'));
    }

    public function create()
    {
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();
        $recetas = Receta::where('estado', 'activo')->orderBy('nombre')->get();
        $productos = Producto::where('estado', 'activo')->orderBy('nombre')->get();

        return view('cotizaciones.create', compact('clientes', 'recetas', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'receta_id' => 'nullable|exists:recetas,id',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'descuento' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
            'terminos_condiciones' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Generar número de cotización
            $ultimaCotizacion = Cotizacion::latest()->first();
            $numero = $ultimaCotizacion ? intval(substr($ultimaCotizacion->numero_cotizacion, 4)) + 1 : 1;
            $numeroCotizacion = 'COT-' . str_pad($numero, 6, '0', STR_PAD_LEFT);

            $subtotal = 0;
            foreach ($request->productos as $item) {
                $subtotal += $item['cantidad'] * $item['precio_unitario'];
            }

            $descuento = $request->descuento ?? 0;
            $total = $subtotal - $descuento;

            $cotizacion = Cotizacion::create([
                'numero_cotizacion' => $numeroCotizacion,
                'cliente_id' => $request->cliente_id,
                'receta_id' => $request->receta_id,
                'fecha_emision' => $request->fecha_emision,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'subtotal' => $subtotal,
                'descuento' => $descuento,
                'total' => $total,
                'estado' => 'pendiente',
                'notas' => $request->notas,
                'terminos_condiciones' => $request->terminos_condiciones,
                'user_id' => auth()->id(),
            ]);

            foreach ($request->productos as $item) {
                $producto = Producto::find($item['producto_id']);
                CotizacionItem::create([
                    'cotizacion_id' => $cotizacion->id,
                    'producto_id' => $item['producto_id'],
                    'descripcion' => $producto->nombre,
                    'cantidad' => $item['cantidad'],
                    'unidad' => $producto->unidad,
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['cantidad'] * $item['precio_unitario'],
                ]);
            }

            DB::commit();
            return redirect()->route('cotizaciones.show', $cotizacion)->with('success', 'Cotización creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear la cotización: ' . $e->getMessage());
        }
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['items.producto', 'cliente', 'user', 'receta', 'prestamo']);
        return view('cotizaciones.show', compact('cotizacion'));
    }

    public function edit(Cotizacion $cotizacion)
    {
        if (in_array($cotizacion->estado, ['aprobada', 'convertida', 'rechazada'])) {
            return back()->with('error', 'No se puede editar una cotización con estado ' . $cotizacion->estado);
        }

        $cotizacion->load('items');
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();
        $recetas = Receta::where('estado', 'activo')->orderBy('nombre')->get();
        $productos = Producto::where('estado', 'activo')->orderBy('nombre')->get();

        return view('cotizaciones.edit', compact('cotizacion', 'clientes', 'recetas', 'productos'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        if (in_array($cotizacion->estado, ['aprobada', 'convertida', 'rechazada'])) {
            return back()->with('error', 'No se puede editar una cotización con estado ' . $cotizacion->estado);
        }

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'receta_id' => 'nullable|exists:recetas,id',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'descuento' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string',
            'terminos_condiciones' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($request->productos as $item) {
                $subtotal += $item['cantidad'] * $item['precio_unitario'];
            }

            $descuento = $request->descuento ?? 0;
            $total = $subtotal - $descuento;

            $cotizacion->update([
                'cliente_id' => $request->cliente_id,
                'receta_id' => $request->receta_id,
                'fecha_emision' => $request->fecha_emision,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'subtotal' => $subtotal,
                'descuento' => $descuento,
                'total' => $total,
                'notas' => $request->notas,
                'terminos_condiciones' => $request->terminos_condiciones,
            ]);

            $cotizacion->items()->delete();

            foreach ($request->productos as $item) {
                $producto = Producto::find($item['producto_id']);
                CotizacionItem::create([
                    'cotizacion_id' => $cotizacion->id,
                    'producto_id' => $item['producto_id'],
                    'descripcion' => $producto->nombre,
                    'cantidad' => $item['cantidad'],
                    'unidad' => $producto->unidad,
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['cantidad'] * $item['precio_unitario'],
                ]);
            }

            DB::commit();
            return redirect()->route('cotizaciones.show', $cotizacion)->with('success', 'Cotización actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar la cotización: ' . $e->getMessage());
        }
    }

    public function destroy(Cotizacion $cotizacion)
    {
        if ($cotizacion->estado === 'convertida') {
            return back()->with('error', 'No se puede eliminar una cotización convertida en préstamo.');
        }

        $cotizacion->delete();
        return redirect()->route('cotizaciones.index')->with('success', 'Cotización eliminada exitosamente.');
    }

    public function aprobar(Cotizacion $cotizacion)
    {
        if ($cotizacion->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden aprobar cotizaciones pendientes.');
        }

        $cotizacion->update([
            'estado' => 'aprobada',
            'aprobada_en' => now(),
            'aprobada_por' => auth()->id(),
        ]);

        return back()->with('success', 'Cotización aprobada exitosamente.');
    }

    public function convertirPrestamo(Cotizacion $cotizacion)
    {
        if ($cotizacion->estado !== 'aprobada') {
            return back()->with('error', 'Solo se pueden convertir cotizaciones aprobadas.');
        }

        if ($cotizacion->prestamo_id) {
            return back()->with('error', 'Esta cotización ya fue convertida en préstamo.');
        }

        return redirect()->route('prestamos.create', ['cotizacion_id' => $cotizacion->id])
            ->with('info', 'Completa los datos del préstamo basado en la cotización.');
    }
}
