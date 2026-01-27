<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cliente::with('usuario')->latest();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('dpi', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $clientes = $query->paginate(15);

        return view('clientes.index-flowbite', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create-flowbite');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'dpi' => 'required|string|size:13|unique:clientes,dpi',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino,otro',
            'estado_civil' => 'required|in:soltero,casado,union_libre,divorciado,viudo',
            'telefono' => 'required|string|max:20',
            'telefono_alternativo' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'direccion_completa' => 'required|string',
            'zona' => 'nullable|string|max:50',
            'profesion' => 'nullable|string|max:255',
            'lugar_trabajo' => 'nullable|string|max:255',
            'puesto_trabajo' => 'nullable|string|max:255',
            'ingreso_mensual' => 'nullable|numeric|min:0',
            'referencia_nombre_1' => 'nullable|string|max:255',
            'referencia_telefono_1' => 'nullable|string|max:20',
            'referencia_parentesco_1' => 'nullable|string|max:100',
            'referencia_nombre_2' => 'nullable|string|max:255',
            'referencia_telefono_2' => 'nullable|string|max:20',
            'referencia_parentesco_2' => 'nullable|string|max:100',
            'notas' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['estado'] = 'activo';

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['prestamos.pagos', 'usuario', 'archivos.usuario']);

        return view('clientes.show-flowbite', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit-flowbite', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'dpi' => 'required|string|size:13|unique:clientes,dpi,' . $cliente->id,
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino,otro',
            'estado_civil' => 'required|in:soltero,casado,union_libre,divorciado,viudo',
            'telefono' => 'required|string|max:20',
            'telefono_alternativo' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'departamento' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'direccion_completa' => 'required|string',
            'zona' => 'nullable|string|max:50',
            'profesion' => 'nullable|string|max:255',
            'lugar_trabajo' => 'nullable|string|max:255',
            'puesto_trabajo' => 'nullable|string|max:255',
            'ingreso_mensual' => 'nullable|numeric|min:0',
            'referencia_nombre_1' => 'nullable|string|max:255',
            'referencia_telefono_1' => 'nullable|string|max:20',
            'referencia_parentesco_1' => 'nullable|string|max:100',
            'referencia_nombre_2' => 'nullable|string|max:255',
            'referencia_telefono_2' => 'nullable|string|max:20',
            'referencia_parentesco_2' => 'nullable|string|max:100',
            'estado' => 'required|in:activo,inactivo,bloqueado',
            'notas' => 'nullable|string',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar si tiene préstamos activos
        if ($cliente->prestamos()->whereIn('estado', ['activo', 'en_mora', 'vencido'])->exists()) {
            return back()->with('error', 'No se puede eliminar un cliente con préstamos activos.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Subir archivo para el cliente
     */
    public function subirArchivo(Request $request, Cliente $cliente)
    {
        $request->validate([
            'archivo' => 'required|file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $nombreOriginal = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $nombreArchivo = time() . '_' . uniqid() . '.' . $extension;
            $ruta = $file->storeAs('clientes/' . $cliente->id, $nombreArchivo, 'public');

            $cliente->archivos()->create([
                'user_id' => Auth::id(),
                'nombre_original' => $nombreOriginal,
                'nombre_archivo' => $nombreArchivo,
                'ruta' => $ruta,
                'mime_type' => $file->getMimeType(),
                'tamano' => $file->getSize(),
                'extension' => $extension,
                'descripcion' => $request->descripcion,
            ]);

            return back()->with('success', 'Archivo subido exitosamente.');
        }

        return back()->with('error', 'Error al subir el archivo.');
    }

    /**
     * Eliminar archivo del cliente
     */
    public function eliminarArchivo(Cliente $cliente, ClienteArchivo $archivo)
    {
        // Verificar que el archivo pertenece al cliente
        if ($archivo->cliente_id !== $cliente->id) {
            abort(403);
        }

        // Eliminar archivo del storage
        Storage::disk('public')->delete($archivo->ruta);

        // Eliminar registro de la base de datos
        $archivo->delete();

        return back()->with('success', 'Archivo eliminado exitosamente.');
    }

    /**
     * Buscar información del PDI usando la API de FEL
     */
    public function searchPdi(Request $request)
    {
        $request->validate([
            'dpi' => 'required|string|size:13',
        ]);

        $dpi = $request->dpi;
        $config = config('services.fel');

        $url = $config['url'] . '?NIT=' . $config['nit'] . '&DATA1=' . $config['data1'] . '&DATA2=CUI%7C' . $dpi . '&USERNAME=' . $config['username'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $config['authorization'],
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200) {
            return response()->json(['error' => 'Error al consultar la API de FEL: HTTP ' . $httpCode], 500);
        }

        $data = json_decode($response, true);

        if (!$data) {
            return response()->json(['error' => 'Respuesta no es JSON válido'], 500);
        }

        if (!isset($data['RESPONSE']) || !is_array($data['RESPONSE']) || empty($data['RESPONSE'])) {
            return response()->json(['error' => 'Respuesta inválida de la API'], 500);
        }

        // Procesar la respuesta y devolver los datos relevantes
        $felData = $data['RESPONSE'][0]; // Tomar el primer elemento del array

        return response()->json([
            'nombre_completo' => $felData['NOMBRE'] ?? null,
            'fecha_nacimiento' => null, // La API no devuelve fecha de nacimiento
            'genero' => null, // La API no devuelve género
        ]);
    }
}
