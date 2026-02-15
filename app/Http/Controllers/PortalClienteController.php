<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\ComprobantePago;
use App\Models\FotoProyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PortalClienteController extends Controller
{
    /**
     * Dashboard del portal del cliente
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Buscar el cliente asociado a este usuario
        $cliente = Cliente::where('portal_user_id', $user->id)->first();

        if (!$cliente) {
            return redirect()->route('login')->with('error', 'No se encontró un cliente asociado a su cuenta.');
        }

        // Obtener préstamos del cliente
        $prestamos = Prestamo::where('cliente_id', $cliente->id)
            ->whereIn('estado', ['activo', 'en_mora', 'completado'])
            ->with(['pagos' => function($query) {
                $query->latest()->limit(5);
            }])
            ->get();

        // Obtener comprobantes de pago del cliente
        $comprobantes = ComprobantePago::where('cliente_id', $cliente->id)
            ->with(['prestamo', 'validador'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Calcular cuota a pagar (suma de todas las cuotas de préstamos activos/en mora)
        $cuotaAPagar = $prestamos->whereIn('estado', ['activo', 'en_mora'])->sum('monto_cuota');
        
        // Calcular total de la deuda (monto total de todos los préstamos activos/en mora)
        $totalDeuda = $prestamos->whereIn('estado', ['activo', 'en_mora'])->sum('monto_total');

        // Estadísticas
        $stats = [
            'cuota_a_pagar' => $cuotaAPagar,
            'total_adeudado' => $prestamos->whereIn('estado', ['activo', 'en_mora'])->sum('saldo_pendiente'),
            'total_deuda' => $totalDeuda,
        ];

        return view('portal-cliente.dashboard', compact('cliente', 'prestamos', 'comprobantes', 'stats'));
    }

    /**
     * Ver detalle de un préstamo
     */
    public function verPrestamo($id)
    {
        $user = Auth::user();
        $cliente = Cliente::where('portal_user_id', $user->id)->firstOrFail();

        $prestamo = Prestamo::where('id', $id)
            ->where('cliente_id', $cliente->id)
            ->with(['pagos.usuario', 'aportaciones.aportador', 'comprobantes'])
            ->firstOrFail();

        // Generar tabla de amortización
        $tablaAmortizacion = $prestamo->generarTablaAmortizacion();

        return view('portal-cliente.prestamo-detalle', compact('prestamo', 'tablaAmortizacion', 'cliente'));
    }

    /**
     * Mostrar formulario para subir comprobante
     */
    public function subirComprobanteForm($prestamo_id)
    {
        $user = Auth::user();
        $cliente = Cliente::where('portal_user_id', $user->id)->firstOrFail();

        $prestamo = Prestamo::where('id', $prestamo_id)
            ->where('cliente_id', $cliente->id)
            ->whereIn('estado', ['activo', 'en_mora'])
            ->firstOrFail();

        return view('portal-cliente.subir-comprobante', compact('prestamo', 'cliente'));
    }

    /**
     * Guardar comprobante de pago
     */
    public function guardarComprobante(Request $request, $prestamo_id)
    {
        $user = Auth::user();
        $cliente = Cliente::where('portal_user_id', $user->id)->firstOrFail();

        $prestamo = Prestamo::where('id', $prestamo_id)
            ->where('cliente_id', $cliente->id)
            ->whereIn('estado', ['activo', 'en_mora'])
            ->firstOrFail();

        $validated = $request->validate([
            'monto_pagado' => 'required|numeric|min:0.01|max:' . $prestamo->saldo_pendiente,
            'fecha_pago' => 'required|date|before_or_equal:today',
            'metodo_pago' => 'required|in:efectivo,transferencia,deposito,cheque,otro',
            'numero_referencia' => 'nullable|string|max:255',
            'archivo_comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB
            'observaciones' => 'nullable|string|max:1000',
        ], [
            'monto_pagado.max' => 'El monto no puede ser mayor al saldo pendiente (Q' . number_format($prestamo->saldo_pendiente, 2) . ').',
            'archivo_comprobante.required' => 'Debe subir un archivo del comprobante de pago.',
            'archivo_comprobante.mimes' => 'El archivo debe ser una imagen (JPG, PNG) o PDF.',
            'archivo_comprobante.max' => 'El archivo no debe pesar más de 5MB.',
        ]);

        try {
            // Guardar el archivo
            $archivo = $request->file('archivo_comprobante');
            $nombreArchivo = 'comprobante_' . time() . '_' . $archivo->getClientOriginalName();
            $rutaArchivo = $archivo->storeAs('comprobantes', $nombreArchivo, 'public');

            // Crear el comprobante
            $comprobante = ComprobantePago::create([
                'prestamo_id' => $prestamo->id,
                'cliente_id' => $cliente->id,
                'monto_pagado' => $validated['monto_pagado'],
                'fecha_pago' => $validated['fecha_pago'],
                'archivo_comprobante' => $rutaArchivo,
                'metodo_pago' => $validated['metodo_pago'],
                'numero_referencia' => $validated['numero_referencia'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
                'estado' => 'pendiente',
            ]);

            // Aquí puedes agregar notificación para administradores
            // \Notification::send(User::role('admin')->get(), new NuevoComprobantePago($comprobante));

            return redirect()->route('portal.dashboard')
                ->with('success', 'Comprobante de pago subido exitosamente. Está pendiente de validación por el administrador.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al subir el comprobante: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Ver mis comprobantes
     */
    public function misComprobantes()
    {
        $user = Auth::user();
        $cliente = Cliente::where('portal_user_id', $user->id)->firstOrFail();

        $comprobantes = ComprobantePago::where('cliente_id', $cliente->id)
            ->with(['prestamo', 'validador', 'pago'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('portal-cliente.mis-comprobantes', compact('comprobantes', 'cliente'));
    }

    /**
     * Ver detalle de un comprobante
     */
    public function verComprobante($id)
    {
        $user = Auth::user();
        $cliente = Cliente::where('portal_user_id', $user->id)->firstOrFail();

        $comprobante = ComprobantePago::where('id', $id)
            ->where('cliente_id', $cliente->id)
            ->with(['prestamo', 'validador', 'pago'])
            ->firstOrFail();

        return view('portal-cliente.comprobante-detalle', compact('comprobante', 'cliente'));
    }

    /**
     * Mostrar fotos del proyecto del cliente
     */
    public function misAvances()
    {
        $user = Auth::user();
        $cliente = Cliente::where('portal_user_id', $user->id)->firstOrFail();

        // Obtener préstamos activos del cliente para asociar fotos
        $prestamos = Prestamo::where('cliente_id', $cliente->id)
            ->whereIn('estado', ['activo', 'en_mora'])
            ->get();

        // Obtener todas las fotos del cliente
        $fotos = FotoProyecto::where('cliente_id', $cliente->id)
            ->with(['prestamo'])
            ->orderBy('fecha_avance', 'desc')
            ->paginate(12);

        return view('portal-cliente.mis-avances', compact('cliente', 'fotos', 'prestamos'));
    }

    /**
     * Guardar nueva foto del proyecto
     */
    public function guardarAvance(Request $request)
    {
        $user = Auth::user();
        $cliente = Cliente::where('portal_user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'prestamo_id' => 'nullable|exists:prestamos,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'imagen' => 'required|image|mimes:jpg,jpeg,png|max:10240', // 10MB
            'fecha_avance' => 'required|date|before_or_equal:today',
            'porcentaje_avance' => 'nullable|numeric|min:0|max:100',
        ], [
            'imagen.required' => 'Debe seleccionar una imagen.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG o PNG.',
            'imagen.max' => 'La imagen no debe pesar más de 10MB.',
        ]);

        try {
            // Verificar que el préstamo pertenece al cliente
            if ($validated['prestamo_id']) {
                $prestamoExiste = Prestamo::where('id', $validated['prestamo_id'])
                    ->where('cliente_id', $cliente->id)
                    ->exists();
                
                if (!$prestamoExiste) {
                    return back()->with('error', 'El préstamo seleccionado no es válido.')->withInput();
                }
            }

            // Guardar la imagen
            $imagen = $request->file('imagen');
            $nombreImagen = 'avance_' . $cliente->id . '_' . time() . '.' . $imagen->getClientOriginalExtension();
            $rutaImagen = $imagen->storeAs('fotos-proyecto', $nombreImagen, 'public');

            // Crear el registro
            FotoProyecto::create([
                'cliente_id' => $cliente->id,
                'prestamo_id' => $validated['prestamo_id'],
                'titulo' => $validated['titulo'],
                'descripcion' => $validated['descripcion'],
                'ruta_imagen' => $rutaImagen,
                'fecha_avance' => $validated['fecha_avance'],
                'porcentaje_avance' => $validated['porcentaje_avance'],
                'estado' => 'pendiente',
            ]);

            return redirect()->route('portal.mis-avances')
                ->with('success', 'Foto de avance subida exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al subir la foto: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Eliminar foto del proyecto
     */
    public function eliminarAvance($id)
    {
        $user = Auth::user();
        $cliente = Cliente::where('portal_user_id', $user->id)->firstOrFail();

        $foto = FotoProyecto::where('id', $id)
            ->where('cliente_id', $cliente->id)
            ->firstOrFail();

        try {
            // Eliminar el archivo
            if (Storage::disk('public')->exists($foto->ruta_imagen)) {
                Storage::disk('public')->delete($foto->ruta_imagen);
            }

            $foto->delete();

            return redirect()->route('portal.mis-avances')
                ->with('success', 'Foto eliminada exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la foto: ' . $e->getMessage());
        }
    }
}
