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
use Barryvdh\DomPDF\Facade\Pdf;

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
                      $q->where('nombre_completo', 'like', "%{$search}%");
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
            'receta_id' => 'required',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'notas' => 'nullable|string',
            'terminos_condiciones' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'tipo_venta' => 'required|in:contado,credito',
            'plazo_meses' => 'nullable|integer|min:1|required_if:tipo_venta,credito',
            'tasa_interes_anual' => 'nullable|numeric|min:0|max:100|required_if:tipo_venta,credito',
            'enganche' => 'nullable|numeric|min:0',
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

            $total = $subtotal;

            // Si receta_id es "libre", guardarlo como null
            $recetaId = ($request->receta_id === 'libre') ? null : $request->receta_id;

            $cotizacion = Cotizacion::create([
                'numero_cotizacion' => $numeroCotizacion,
                'cliente_id' => $request->cliente_id,
                'receta_id' => $recetaId,
                'fecha_emision' => $request->fecha_emision,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'subtotal' => $subtotal,
                'descuento' => 0,
                'total' => $total,
                'tipo_venta' => $request->tipo_venta,
                'plazo_meses' => $request->tipo_venta === 'credito' ? $request->plazo_meses : null,
                'tasa_interes_anual' => $request->tipo_venta === 'credito' ? $request->tasa_interes_anual : null,
                'enganche' => $request->tipo_venta === 'credito' ? $request->enganche : null,
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
                    'descripcion' => $item['descripcion'] ?? $producto->nombre,
                    'cantidad' => $item['cantidad'],
                    'unidad' => $producto->unidad_medida,
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
        $cotizacion->load('items');
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();
        $recetas = Receta::where('estado', 'activo')->orderBy('nombre')->get();
        $productos = Producto::where('estado', 'activo')->orderBy('nombre')->get();

        return view('cotizaciones.edit', compact('cotizacion', 'clientes', 'recetas', 'productos'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'receta_id' => 'nullable|exists:recetas,id',
            'fecha_emision' => 'required|date',
            'fecha_vencimiento' => 'required|date|after_or_equal:fecha_emision',
            'descuento' => 'nullable|numeric|min:0',
            'estado' => 'required|in:pendiente,aprobada,rechazada,vencida,convertida',
            'notas' => 'nullable|string',
            'terminos_condiciones' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'tipo_venta' => 'required|in:contado,credito',
            'plazo_meses' => 'nullable|integer|min:1|required_if:tipo_venta,credito',
            'tasa_interes_anual' => 'nullable|numeric|min:0|max:100|required_if:tipo_venta,credito',
            'enganche' => 'nullable|numeric|min:0',
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
                'tipo_venta' => $request->tipo_venta,
                'plazo_meses' => $request->tipo_venta === 'credito' ? $request->plazo_meses : null,
                'tasa_interes_anual' => $request->tipo_venta === 'credito' ? $request->tasa_interes_anual : null,
                'enganche' => $request->tipo_venta === 'credito' ? $request->enganche : null,
                'estado' => $request->estado,
                'notas' => $request->notas,
                'terminos_condiciones' => $request->terminos_condiciones,
            ]);

            $cotizacion->items()->delete();

            foreach ($request->productos as $item) {
                $producto = Producto::find($item['producto_id']);
                CotizacionItem::create([
                    'cotizacion_id' => $cotizacion->id,
                    'producto_id' => $item['producto_id'],
                    'descripcion' => $item['descripcion'] ?? $producto->nombre,
                    'cantidad' => $item['cantidad'],
                    'unidad' => $producto->unidad_medida,
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
        if (!in_array($cotizacion->estado, ['pendiente', 'aprobada'])) {
            return back()->with('error', 'Solo se pueden convertir cotizaciones pendientes o aprobadas.');
        }

        if ($cotizacion->prestamo_id) {
            return back()->with('error', 'Esta cotización ya fue convertida en préstamo.');
        }

        return redirect()->route('prestamos.create', ['cotizacion_id' => $cotizacion->id])
            ->with('info', 'Completa los datos del préstamo basado en la cotización.');
    }

    public function exportPdf(Cotizacion $cotizacion)
    {
        $cotizacion->load(['items.producto', 'cliente', 'user', 'receta']);

        // Calcular tabla de amortización si existe financiamiento en la cotización
        $planPagos = null;
        if ($cotizacion->plazo_meses && $cotizacion->tasa_interes_anual) {
            $planPagos = $this->calcularPlanPagos(
                $cotizacion->total - ($cotizacion->enganche ?? 0),
                $cotizacion->plazo_meses,
                $cotizacion->tasa_interes_anual
            );
        }

        $pdf = Pdf::loadView('cotizaciones.pdf-full', compact('cotizacion', 'planPagos'));
        return $pdf->download('cotizacion-' . $cotizacion->numero_cotizacion . '.pdf');
    }

    public function exportPdfAmortizacion(Cotizacion $cotizacion)
    {
        $cotizacion->load(['cliente']);

        if (!$cotizacion->plazo_meses || !$cotizacion->tasa_interes_anual) {
            return back()->with('error', 'Esta cotización no tiene plan de financiamiento.');
        }

        $planPagos = $this->calcularPlanPagos(
            $cotizacion->total - ($cotizacion->enganche ?? 0),
            $cotizacion->plazo_meses,
            $cotizacion->tasa_interes_anual
        );

        $pdf = Pdf::loadView('cotizaciones.pdf-amortizacion', compact('cotizacion', 'planPagos'));
        return $pdf->download('amortizacion-' . $cotizacion->numero_cotizacion . '.pdf');
    }

    private function calcularPlanPagos($monto, $plazoMeses, $tasaAnual)
    {
        $tasaMensual = $tasaAnual / 12 / 100;
        $cuotaMensual = $monto * ($tasaMensual * pow(1 + $tasaMensual, $plazoMeses)) / (pow(1 + $tasaMensual, $plazoMeses) - 1);

        $planPagos = [];
        $saldoRestante = $monto;

        for ($i = 1; $i <= $plazoMeses; $i++) {
            $interesMes = $saldoRestante * $tasaMensual;
            $capitalMes = $cuotaMensual - $interesMes;
            $saldoRestante -= $capitalMes;

            // Ajustar última cuota por redondeo
            if ($i == $plazoMeses) {
                $capitalMes += $saldoRestante;
                $saldoRestante = 0;
            }

            $planPagos[] = [
                'mes' => $i,
                'cuota' => round($cuotaMensual, 2),
                'capital' => round($capitalMes, 2),
                'interes' => round($interesMes, 2),
                'saldo' => round($saldoRestante, 2)
            ];
        }

        return $planPagos;
    }
}
