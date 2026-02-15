<?php

namespace App\Http\Controllers;

use App\Models\Contratista;
use App\Models\ContratistaProyecto;
use App\Models\ContratistaArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContratistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contratista::query();

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre_completo', 'like', "%{$buscar}%")
                  ->orWhere('nombre_empresa', 'like', "%{$buscar}%")
                  ->orWhere('codigo', 'like', "%{$buscar}%")
                  ->orWhere('telefono1', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('especialidad')) {
            $query->where('especialidad', 'like', "%{$request->especialidad}%");
        }

        $contratistas = $query->withCount(['proyectos', 'proyectosCompletados'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('contratistas.index', compact('contratistas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contratistas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_empresa' => 'nullable|string|max:255',
            'dpi' => 'nullable|string|max:20',
            'nit' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'municipio' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'telefono1' => 'required|string|max:20',
            'telefono2' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'especialidad' => 'nullable|string|max:255',
            'tipo_servicio' => 'required|in:construccion,remodelacion,ambos',
            'servicios_ofrecidos' => 'nullable|string',
            'anos_experiencia' => 'nullable|integer|min:0',
            'calificacion' => 'nullable|numeric|min:0|max:5',
            'notas' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo,suspendido',
        ]);

        // Generar código automático
        $validated['codigo'] = Contratista::generateCodigo();

        $contratista = Contratista::create($validated);

        return redirect()->route('contratistas.show', $contratista)
            ->with('success', 'Contratista creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contratista $contratista)
    {
        $contratista->load(['proyectos' => function($query) {
            $query->orderBy('created_at', 'desc');
        }, 'archivos' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('contratistas.show', compact('contratista'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contratista $contratista)
    {
        return view('contratistas.edit', compact('contratista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contratista $contratista)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'nombre_empresa' => 'nullable|string|max:255',
            'dpi' => 'nullable|string|max:20',
            'nit' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'municipio' => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'telefono1' => 'required|string|max:20',
            'telefono2' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'especialidad' => 'nullable|string|max:255',
            'tipo_servicio' => 'required|in:construccion,remodelacion,ambos',
            'servicios_ofrecidos' => 'nullable|string',
            'anos_experiencia' => 'nullable|integer|min:0',
            'calificacion' => 'nullable|numeric|min:0|max:5',
            'notas' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo,suspendido',
        ]);

        $contratista->update($validated);

        return redirect()->route('contratistas.show', $contratista)
            ->with('success', 'Contratista actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contratista $contratista)
    {
        $contratista->delete();

        return redirect()->route('contratistas.index')
            ->with('success', 'Contratista eliminado exitosamente.');
    }

    /**
     * Agregar proyecto
     */
    public function agregarProyecto(Request $request, Contratista $contratista)
    {
        $validated = $request->validate([
            'nombre_proyecto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'ubicacion' => 'nullable|string|max:255',
            'cliente' => 'nullable|string|max:255',
            'tipo_proyecto' => 'required|in:construccion_nueva,remodelacion,ampliacion,otro',
            'monto_proyecto' => 'nullable|numeric|min:0',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:planificacion,en_proceso,completado,cancelado',
            'materiales_utilizados' => 'nullable|string',
            'notas' => 'nullable|string',
        ]);

        $proyecto = $contratista->proyectos()->create($validated);

        // Calcular duración si hay fechas
        if ($validated['fecha_inicio'] && $validated['fecha_fin']) {
            $proyecto->calcularDuracion();
        }

        return redirect()->route('contratistas.show', ['contratista' => $contratista->id, 'tab' => 'proyectos'])
            ->with('success', 'Proyecto agregado exitosamente.');
    }

    /**
     * Eliminar proyecto
     */
    public function eliminarProyecto(Contratista $contratista, ContratistaProyecto $proyecto)
    {
        $proyecto->delete();

        return redirect()->route('contratistas.show', ['contratista' => $contratista->id, 'tab' => 'proyectos'])
            ->with('success', 'Proyecto eliminado exitosamente.');
    }

    /**
     * Subir archivo
     */
    public function subirArchivo(Request $request, Contratista $contratista)
    {
        $validated = $request->validate([
            'archivo' => 'required|file|max:10240', // 10MB máximo
            'tipo_documento' => 'required|in:dpi,cedula_comercio,patente_comercio,certificacion_laboral,certificacion_tecnica,titulo_profesional,referencias,contrato,foto_proyecto,otro',
            'descripcion' => 'nullable|string',
            'fecha_vigencia' => 'nullable|date',
        ]);

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            
            // Guardar archivo
            $path = $file->store('contratistas/' . $contratista->id, 'public');

            // Crear registro
            $contratista->archivos()->create([
                'nombre_archivo' => $file->getClientOriginalName(),
                'tipo_documento' => $validated['tipo_documento'],
                'ruta_archivo' => $path,
                'mime_type' => $file->getMimeType(),
                'tamano_kb' => round($file->getSize() / 1024),
                'descripcion' => $validated['descripcion'] ?? null,
                'fecha_vigencia' => $validated['fecha_vigencia'] ?? null,
                'uploaded_by' => Auth::id(),
            ]);
        }

        return redirect()->route('contratistas.show', ['contratista' => $contratista->id, 'tab' => 'archivos'])
            ->with('success', 'Archivo subido exitosamente.');
    }

    /**
     * Descargar archivo
     */
    public function descargarArchivo(Contratista $contratista, ContratistaArchivo $archivo)
    {
        if (!Storage::disk('public')->exists($archivo->ruta_archivo)) {
            return redirect()->back()->with('error', 'Archivo no encontrado.');
        }

        return response()->download(
            Storage::disk('public')->path($archivo->ruta_archivo),
            $archivo->nombre_archivo
        );
    }

    /**
     * Eliminar archivo
     */
    public function eliminarArchivo(Contratista $contratista, ContratistaArchivo $archivo)
    {
        // Eliminar archivo físico
        if (Storage::disk('public')->exists($archivo->ruta_archivo)) {
            Storage::disk('public')->delete($archivo->ruta_archivo);
        }

        // Eliminar registro
        $archivo->delete();

        return redirect()->route('contratistas.show', ['contratista' => $contratista->id, 'tab' => 'archivos'])
            ->with('success', 'Archivo eliminado exitosamente.');
    }
}
