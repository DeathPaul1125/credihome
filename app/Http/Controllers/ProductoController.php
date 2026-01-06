<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Producto::query()->latest();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('categoria', 'like', "%{$search}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $productos = $query->paginate(15);
        $categorias = Producto::select('categoria')->distinct()->pluck('categoria');

        return view('productos.index-flowbite', compact('productos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create-flowbite');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|unique:productos,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'categoria' => 'required|string',
            'marca' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'notas' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        Producto::create($validated);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return view('productos.show-flowbite', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit-flowbite', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string',
            'precio_unitario' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'categoria' => 'required|string',
            'marca' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'notas' => 'nullable|string',
        ]);

        $producto->update($validated);

        return redirect()->route('productos.show', $producto)
            ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Verificar si tiene items en recetas o cotizaciones
        if ($producto->recetaItems()->exists() || $producto->cotizacionItems()->exists()) {
            return back()->with('error', 'No se puede eliminar un producto que está en uso.');
        }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Mostrar formulario de importación
     */
    public function importForm()
    {
        return view('productos.import');
    }

    /**
     * Procesar archivo de importación
     */
    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt|max:5120',
            'accion' => 'required|in:crear,actualizar,ambas',
        ]);

        $file = $request->file('archivo');
        $accion = $request->accion;

        // Leer archivo CSV
        $handle = fopen($file->getRealPath(), 'r');

        // Leer encabezado
        $header = fgetcsv($handle, 1000, ',');

        // Validar encabezados requeridos
        $requiredHeaders = ['codigo', 'nombre', 'categoria', 'unidad_medida', 'precio_unitario'];
        $missingHeaders = array_diff($requiredHeaders, $header);

        if (!empty($missingHeaders)) {
            fclose($handle);
            return back()->with('error', 'Faltan columnas requeridas: ' . implode(', ', $missingHeaders));
        }

        $imported = 0;
        $updated = 0;
        $errors = [];
        $line = 1;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $line++;

                // Combinar encabezados con valores
                $data = array_combine($header, $row);

                // Validar datos
                $validator = Validator::make($data, [
                    'codigo' => 'required|string|max:50',
                    'nombre' => 'required|string|max:255',
                    'categoria' => 'required|string|max:100',
                    'unidad_medida' => 'required|string|max:20',
                    'precio_unitario' => 'required|numeric|min:0',
                    'stock_actual' => 'nullable|numeric|min:0',
                    'stock_minimo' => 'nullable|numeric|min:0',
                    'marca' => 'nullable|string|max:100',
                    'descripcion' => 'nullable|string',
                    'estado' => 'nullable|in:Activo,Inactivo',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Línea {$line}: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // Preparar datos para insertar/actualizar
                $productData = [
                    'nombre' => $data['nombre'],
                    'categoria' => $data['categoria'],
                    'unidad_medida' => $data['unidad_medida'],
                    'precio_unitario' => $data['precio_unitario'],
                    'stock_actual' => $data['stock_actual'] ?? 0,
                    'stock_minimo' => $data['stock_minimo'] ?? 0,
                    'marca' => $data['marca'] ?? null,
                    'descripcion' => $data['descripcion'] ?? null,
                    'estado' => $data['estado'] ?? 'Activo',
                    'usuario_id' => Auth::id(),
                ];

                // Buscar producto existente por código
                $existente = Producto::where('codigo', $data['codigo'])->first();

                if ($existente) {
                    if ($accion === 'crear') {
                        $errors[] = "Línea {$line}: Producto con código {$data['codigo']} ya existe (modo: solo crear)";
                        continue;
                    }
                    // Actualizar
                    $existente->update($productData);
                    $updated++;
                } else {
                    if ($accion === 'actualizar') {
                        $errors[] = "Línea {$line}: Producto con código {$data['codigo']} no existe (modo: solo actualizar)";
                        continue;
                    }
                    // Crear nuevo
                    $productData['codigo'] = $data['codigo'];
                    Producto::create($productData);
                    $imported++;
                }
            }

            fclose($handle);
            DB::commit();

            $message = "Importación completada: {$imported} productos creados, {$updated} actualizados.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " errores encontrados.";
                session()->flash('errors_detalle', $errors);
            }

            return redirect()->route('productos.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Error al procesar archivo: ' . $e->getMessage());
        }
    }

    /**
     * Descargar plantilla CSV de ejemplo
     */
    public function downloadTemplate()
    {
        $filename = 'plantilla_productos.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $columns = [
            'codigo',
            'nombre',
            'categoria',
            'unidad_medida',
            'precio_unitario',
            'stock_actual',
            'stock_minimo',
            'marca',
            'descripcion',
            'estado'
        ];

        $ejemplos = [
            [
                'CEM-001',
                'Cemento Portland Gris 50kg',
                'Cemento',
                'Bolsa',
                '95.50',
                '100',
                '20',
                'Progreso',
                'Cemento gris tipo I para uso general',
                'Activo'
            ],
            [
                'HIE-002',
                'Varilla Corrugada 3/8" x 6m',
                'Hierro',
                'Unidad',
                '45.00',
                '500',
                '50',
                'SIDEGUA',
                'Varilla de acero corrugada grado 40',
                'Activo'
            ],
            [
                'BLO-003',
                'Block de 15x20x40 cm',
                'Blocks',
                'Unidad',
                '3.75',
                '2000',
                '200',
                'Cemacon',
                'Block hueco de concreto',
                'Activo'
            ],
            [
                'ARE-004',
                'Arena de Rio m³',
                'Agregados',
                'Metro Cúbico',
                '150.00',
                '50',
                '10',
                '',
                'Arena lavada para construcción',
                'Activo'
            ],
            [
                'PIE-005',
                'Piedrín 3/4" m³',
                'Agregados',
                'Metro Cúbico',
                '180.00',
                '30',
                '10',
                '',
                'Piedrín triturado calibre 3/4',
                'Activo'
            ],
        ];

        $callback = function() use ($columns, $ejemplos) {
            $file = fopen('php://output', 'w');

            // BOM para UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Encabezados
            fputcsv($file, $columns);

            // Ejemplos
            foreach ($ejemplos as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
