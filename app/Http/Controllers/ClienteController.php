<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteArchivo;
use App\Models\FotoProyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $cliente = Cliente::create($validated);

        // Si es una petición AJAX, devolver JSON
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente creado exitosamente.',
                'cliente' => [
                    'id' => $cliente->id,
                    'nombre_completo' => $cliente->nombre_completo,
                    'dpi' => $cliente->dpi,
                    'telefono' => $cliente->telefono,
                ]
            ], 201);
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Store a newly created client quick (for AJAX requests from quotations, etc.)
     */
    public function storeQuick(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'dpi' => 'required|string|size:13|unique:clientes,dpi',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion_completa' => 'nullable|string',
            'departamento' => 'nullable|string|max:255',
            'municipio' => 'nullable|string|max:255',
        ]);

        // Campos con valores por defecto para creación rápida
        $validated['user_id'] = Auth::id();
        $validated['estado'] = 'activo';
        $validated['fecha_nacimiento'] = '2000-01-01';
        $validated['genero'] = 'masculino';
        $validated['estado_civil'] = 'soltero';

        // Solo aplicar default si no se proporcionaron
        if (!isset($validated['departamento'])) {
            $validated['departamento'] = 'Guatemala';
        }
        if (!isset($validated['municipio'])) {
            $validated['municipio'] = 'Guatemala';
        }
        if (!isset($validated['direccion_completa'])) {
            $validated['direccion_completa'] = 'Sin dirección';
        }

        $cliente = Cliente::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cliente creado exitosamente.',
            'cliente' => [
                'id' => $cliente->id,
                'nombre_completo' => $cliente->nombre_completo,
                'dpi' => $cliente->dpi,
                'telefono' => $cliente->telefono,
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['prestamos.pagos', 'usuario', 'archivos.usuario', 'fotosProyecto.prestamo', 'contratos.contratista']);

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
        try {
            $request->validate([
                'dpi' => 'required|string|size:13',
            ]);

            $dpi = $request->dpi;
            $config = config('services.fel');

            // Validar que la configuración existe
            if (!$config || !isset($config['url'], $config['nit'], $config['data1'], $config['username'], $config['authorization'])) {
                return response()->json(['error' => 'Configuración de FEL incompleta. Contacte al administrador.'], 500);
            }

            $url = $config['url'] . '?NIT=' . $config['nit'] . '&DATA1=' . $config['data1'] . '&DATA2=CUI%7C' . $dpi . '&USERNAME=' . $config['username'];

            $curl = curl_init();

            if ($curl === false) {
                return response()->json(['error' => 'Error al inicializar la conexión'], 500);
            }

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $config['authorization'],
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $curlError = curl_error($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($response === false) {
                \Log::error('CURL Error en searchPdi: ' . $curlError);
                return response()->json(['error' => 'Error de conexión con la API de FEL'], 500);
            }

            if ($httpCode !== 200) {
                \Log::error('HTTP Error en searchPdi: ' . $httpCode . ' - Response: ' . $response);
                return response()->json(['error' => 'Error al consultar la API de FEL: HTTP ' . $httpCode], 500);
            }

            $data = json_decode($response, true);

            if (!$data) {
                \Log::error('JSON inválido en searchPdi. Response: ' . $response);
                return response()->json(['error' => 'Respuesta no es JSON válido'], 500);
            }

            if (!isset($data['RESPONSE']) || !is_array($data['RESPONSE']) || empty($data['RESPONSE'])) {
                \Log::warning('Respuesta vacía o inválida de FEL API: ' . json_encode($data));
                return response()->json(['error' => 'No se encontró información para el DPI proporcionado'], 404);
            }

            // Procesar la respuesta y devolver los datos relevantes
            $felData = $data['RESPONSE'][0]; // Tomar el primer elemento del array

            return response()->json([
                'nombre_completo' => $felData['NOMBRE'] ?? null,
                'fecha_nacimiento' => null, // La API no devuelve fecha de nacimiento
                'genero' => null, // La API no devuelve género
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'DPI inválido. Debe tener 13 dígitos.'], 422);
        } catch (\Exception $e) {
            \Log::error('Error en searchPdi: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            return response()->json(['error' => 'Error interno del servidor. Por favor intente nuevamente.'], 500);
        }
    }

    /**
     * Activar portal del cliente y crear credenciales
     */
    public function activarPortal($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Verificar si ya tiene usuario
        if ($cliente->portal_user_id) {
            $user = User::find($cliente->portal_user_id);
            if ($user) {
                // Reactivar si estaba desactivado
                $cliente->update(['portal_activo' => true]);

                return back()->with('info', 'El cliente ya tiene acceso al portal. Se ha reactivado el acceso.');
            }
        }

        // Generar email y contraseña
        $email = $this->generarEmailUnico($cliente);
        $password = Str::random(8); // Contraseña aleatoria de 8 caracteres

        // Crear usuario
        $user = User::create([
            'name' => $cliente->nombre_completo,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(), // Auto-verificar el email
        ]);

        // Actualizar cliente con el user_id y activar portal
        $cliente->update([
            'portal_user_id' => $user->id,
            'portal_activo' => true,
        ]);

        // Preparar mensaje para WhatsApp
        $mensaje = $this->generarMensajeCredenciales($cliente, $email, $password);

        return back()->with([
            'success' => 'Portal activado correctamente.',
            'credentials' => [
                'email' => $email,
                'password' => $password,
                'whatsapp_message' => $mensaje,
                'telefono' => $this->limpiarTelefono($cliente->telefono),
            ]
        ]);
    }

    /**
     * Desactivar portal del cliente
     */
    public function desactivarPortal($id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->update(['portal_activo' => false]);

        return back()->with('success', 'Portal desactivado correctamente.');
    }

    /**
     * Regenerar contraseña del portal
     */
    public function regenerarPassword($id)
    {
        $cliente = Cliente::findOrFail($id);

        if (!$cliente->portal_user_id) {
            return back()->with('error', 'El cliente no tiene acceso al portal.');
        }

        $user = User::findOrFail($cliente->portal_user_id);
        $password = Str::random(8);

        $user->update([
            'password' => Hash::make($password),
        ]);

        // Preparar mensaje para WhatsApp
        $mensaje = $this->generarMensajeCredenciales($cliente, $user->email, $password);

        return back()->with([
            'success' => 'Contraseña regenerada correctamente.',
            'credentials' => [
                'email' => $user->email,
                'password' => $password,
                'whatsapp_message' => $mensaje,
                'telefono' => $this->limpiarTelefono($cliente->telefono),
            ]
        ]);
    }

    /**
     * Generar email único para el cliente
     */
    private function generarEmailUnico($cliente)
    {
        // Intentar con DPI primero
        $baseEmail = 'cliente-' . $cliente->dpi;
        $email = $baseEmail . '@credihome.gt';
        $counter = 1;

        while (User::where('email', $email)->exists()) {
            $email = $baseEmail . '-' . $counter . '@credihome.gt';
            $counter++;
        }

        return $email;
    }

    /**
     * Limpiar número de teléfono para WhatsApp
     */
    private function limpiarTelefono($telefono)
    {
        // Remover cualquier caracter que no sea número
        $telefono = preg_replace('/[^0-9]/', '', $telefono);

        // Si tiene 8 dígitos, agregar código de país de Guatemala (502)
        if (strlen($telefono) === 8) {
            $telefono = '502' . $telefono;
        }

        return $telefono;
    }

    /**
     * Generar mensaje de credenciales para WhatsApp
     */
    private function generarMensajeCredenciales($cliente, $email, $password)
    {
        $url = url('/login');

        return "🏦 *CREDIHOME - Acceso al Portal de Clientes*\n\n"
            . "Hola *{$cliente->nombre_completo}*,\n\n"
            . "Ya puedes acceder a tu portal de clientes para consultar tus préstamos y subir comprobantes de pago.\n\n"
            . "📧 *Usuario:* {$email}\n"
            . "🔑 *Contraseña:* {$password}\n\n"
            . "🌐 *Acceder al portal:*\n{$url}\n\n"
            . "⚠️ Te recomendamos cambiar tu contraseña después del primer acceso.\n\n"
            . "Si tienes alguna duda, contáctanos.";
    }

    /**
     * Aprobar una foto de proyecto del cliente
     */
    public function aprobarFotoProyecto(Request $request, $id)
    {
        $foto = FotoProyecto::findOrFail($id);
        $foto->update([
            'estado' => 'aprobado',
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
            'comentario_admin' => $request->comentario_admin,
        ]);

        return back()->with('success', 'Foto aprobada correctamente.');
    }

    /**
     * Rechazar una foto de proyecto del cliente
     */
    public function rechazarFotoProyecto(Request $request, $id)
    {
        $foto = FotoProyecto::findOrFail($id);
        $foto->update([
            'estado' => 'rechazado',
            'aprobado_por' => Auth::id(),
            'fecha_aprobacion' => now(),
            'comentario_admin' => $request->comentario_admin,
        ]);

        return back()->with('success', 'Foto rechazada correctamente.');
    }
}
