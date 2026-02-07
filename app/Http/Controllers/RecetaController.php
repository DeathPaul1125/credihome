<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\RecetaItem;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{
    public function index(Request $request)
    {
        $query = Receta::with(['user', 'cliente'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('tipo_vivienda', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('tipo_vivienda')) {
            $query->where('tipo_vivienda', $request->tipo_vivienda);
        }

        if ($request->filled('es_plantilla')) {
            $query->where('es_plantilla', $request->es_plantilla === '1');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $recetas = $query->paginate(15);

        return view('recetas.index', compact('recetas'));
    }

    public function create()
    {
        $productos = Producto::where('estado', 'activo')->orderBy('nombre')->get();
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();

        return view('recetas.create', compact('productos', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_vivienda' => 'required|string',
            'area_construccion' => 'nullable|numeric|min:0',
            'es_plantilla' => 'boolean',
            'cliente_id' => 'nullable|exists:clientes,id',
            'estado' => 'required|in:activo,inactivo',
            'notas' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $receta = Receta::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'tipo_vivienda' => $request->tipo_vivienda,
                'area_construccion' => $request->area_construccion,
                'es_plantilla' => $request->boolean('es_plantilla', true),
                'cliente_id' => $request->cliente_id,
                'estado' => $request->estado,
                'notas' => $request->notas,
                'user_id' => auth()->id(),
                'costo_total' => 0,
            ]);

            $costoTotal = 0;
            foreach ($request->productos as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                $costoTotal += $subtotal;

                RecetaItem::create([
                    'receta_id' => $receta->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $subtotal,
                    'notas' => $item['notas'] ?? null,
                ]);
            }

            $receta->update(['costo_total' => $costoTotal]);

            DB::commit();
            return redirect()->route('recetas.show', $receta)->with('success', 'Receta creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear la receta: ' . $e->getMessage());
        }
    }

    public function show(Receta $receta)
    {
        $receta->load(['items.producto', 'cliente', 'user']);
        return view('recetas.show', compact('receta'));
    }

    public function edit(Receta $receta)
    {
        $receta->load('items');
        $productos = Producto::where('estado', 'activo')->orderBy('nombre')->get();
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();

        return view('recetas.edit', compact('receta', 'productos', 'clientes'));
    }

    public function update(Request $request, Receta $receta)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo_vivienda' => 'required|string',
            'area_construccion' => 'nullable|numeric|min:0',
            'es_plantilla' => 'boolean',
            'cliente_id' => 'nullable|exists:clientes,id',
            'estado' => 'required|in:activo,inactivo',
            'notas' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $receta->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'tipo_vivienda' => $request->tipo_vivienda,
                'area_construccion' => $request->area_construccion,
                'es_plantilla' => $request->boolean('es_plantilla', true),
                'cliente_id' => $request->cliente_id,
                'estado' => $request->estado,
                'notas' => $request->notas,
            ]);

            // Eliminar items anteriores
            $receta->items()->delete();

            $costoTotal = 0;
            foreach ($request->productos as $item) {
                $subtotal = $item['cantidad'] * $item['precio_unitario'];
                $costoTotal += $subtotal;

                RecetaItem::create([
                    'receta_id' => $receta->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $subtotal,
                    'notas' => $item['notas'] ?? null,
                ]);
            }

            $receta->update(['costo_total' => $costoTotal]);

            DB::commit();
            return redirect()->route('recetas.show', $receta)->with('success', 'Receta actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar la receta: ' . $e->getMessage());
        }
    }

    public function destroy(Receta $receta)
    {
        try {
            // Verificar si tiene cotizaciones asociadas
            if ($receta->cotizaciones()->count() > 0) {
                return back()->with('error', 'No se puede eliminar la receta porque tiene cotizaciones asociadas.');
            }

            $receta->delete();
            return redirect()->route('recetas.index')->with('success', 'Receta eliminada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la receta: ' . $e->getMessage());
        }
    }

    public function clonar(Receta $receta)
    {
        DB::beginTransaction();
        try {
            $nuevaReceta = $receta->replicate();
            $nuevaReceta->nombre = $receta->nombre . ' (Copia)';
            $nuevaReceta->es_plantilla = false;
            $nuevaReceta->cliente_id = null;
            $nuevaReceta->user_id = auth()->id();
            $nuevaReceta->save();

            foreach ($receta->items as $item) {
                RecetaItem::create([
                    'receta_id' => $nuevaReceta->id,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'unidad' => $item->unidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal' => $item->subtotal,
                    'notas' => $item->notas,
                ]);
            }

            DB::commit();
            return redirect()->route('recetas.edit', $nuevaReceta)->with('success', 'Receta clonada exitosamente. Puedes editarla ahora.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al clonar la receta: ' . $e->getMessage());
        }
    }
}
