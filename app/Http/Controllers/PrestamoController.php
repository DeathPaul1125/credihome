<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Prestamo;
use App\Models\Aportador;
use App\Models\Aportacion;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prestamo::with(['cliente', 'usuario'])->latest();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_prestamo', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q2) use ($search) {
                      $q2->where('nombre_completo', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fecha
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_desembolso', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_desembolso', '<=', $request->fecha_hasta);
        }

        $prestamos = $query->paginate(15);

        return view('prestamos.index-flowbite', compact('prestamos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();
        $aportadores = Aportador::where('estado', 'activo')
            ->where('capital_disponible', '>', 0)
            ->orderBy('nombre')
            ->get();

        $clienteSeleccionado = null;
        $cotizacion = null;

        // Si viene de una cotización, cargar los datos
        if ($request->filled('cotizacion_id')) {
            $cotizacion = Cotizacion::with('cliente')->find($request->cotizacion_id);
            if ($cotizacion) {
                $clienteSeleccionado = $cotizacion->cliente;
            }
        } elseif ($request->filled('cliente_id')) {
            $clienteSeleccionado = Cliente::find($request->cliente_id);
        }

        return view('prestamos.create-flowbite', compact('clientes', 'clienteSeleccionado', 'aportadores', 'cotizacion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log de debug
        \Log::info('=== INTENTO DE CREAR PRÉSTAMO ===');
        \Log::info('Request data:', $request->all());

        // Limpiar aportadores vacíos antes de validar
        if ($request->has('aportadores') && is_array($request->aportadores)) {
            $aportadoresFiltrados = array_filter($request->aportadores, function($aportador) {
                return !empty($aportador['id']) && !empty($aportador['monto']) && $aportador['monto'] > 0;
            });
            $request->merge(['aportadores' => array_values($aportadoresFiltrados)]);
            \Log::info('Aportadores filtrados:', $request->aportadores);
        }

        try {
            $validated = $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'cotizacion_id' => 'nullable|exists:cotizaciones,id',
                'monto_prestado' => 'required|numeric|min:500|max:100000',
                'tasa_interes' => 'required|numeric|min:0|max:100',
                'tipo_interes' => 'required|in:simple,compuesto',
                'plazo' => 'required|integer|min:1|max:60',
                'frecuencia_pago' => 'required|in:semanal,quincenal,mensual',
                'fecha_desembolso' => 'required|date',
                'tipo_garantia' => 'required|in:ninguna,prenda,hipoteca,fiador,otro',
                'descripcion_garantia' => 'nullable|string',
                'notas' => 'nullable|string',
                'aportadores' => 'nullable|array',
                'aportadores.*.id' => 'required|exists:aportadores,id',
                'aportadores.*.monto' => 'required|numeric|min:0.01',
            ]);

            \Log::info('Validación exitosa');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación:', $e->errors());
            throw $e;
        }

        \Log::info('Iniciando validaciones adicionales');

        // Validar que las aportaciones sumen el monto del préstamo
        if (!empty($validated['aportadores'])) {
            \Log::info('Validando suma de aportaciones');
            $totalAportaciones = collect($validated['aportadores'])->sum('monto');
            $montoPrestamo = (float) $validated['monto_prestado'];

            if (abs($totalAportaciones - $montoPrestamo) > 0.01) {
                \Log::warning('Total de aportaciones no coincide con monto del préstamo');
                return back()->withErrors([
                    'aportadores' => "El total de aportaciones (Q{$totalAportaciones}) debe ser igual al monto del préstamo (Q{$montoPrestamo})."
                ])->withInput();
            }

            // Validar que cada aportador tenga suficiente capital
            \Log::info('Validando capital disponible de aportadores');
            foreach ($validated['aportadores'] as $aportacionData) {
                if (empty($aportacionData['id']) || empty($aportacionData['monto'])) {
                    continue;
                }

                $aportador = Aportador::find($aportacionData['id']);
                if (!$aportador) {
                    continue;
                }

                if ($aportador->capital_disponible < $aportacionData['monto']) {
                    \Log::warning("Aportador {$aportador->nombre} no tiene capital suficiente");
                    return back()->withErrors([
                        'aportadores' => "El aportador {$aportador->nombre} no tiene suficiente capital disponible (Tiene: Q{$aportador->capital_disponible}, Necesita: Q{$aportacionData['monto']})."
                    ])->withInput();
                }
            }
        }

        \Log::info('Iniciando transacción DB');
        DB::beginTransaction();
        try {
            \Log::info('Generando número de préstamo');
            // Generar número de préstamo dentro de la transacción (incluyendo soft deleted para evitar duplicados)
            $year = date('Y');
            $lastPrestamo = Prestamo::withTrashed()
                ->where('numero_prestamo', 'like', "P-{$year}-%")
                ->orderBy('numero_prestamo', 'desc')
                ->lockForUpdate()
                ->first();

            if ($lastPrestamo) {
                $lastNumber = (int) substr($lastPrestamo->numero_prestamo, -5);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $numeroPrestamo = 'P-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            \Log::info('Número de préstamo generado: ' . $numeroPrestamo);

            \Log::info('Creando objeto Prestamo');
            $prestamo = new Prestamo($validated);
            $prestamo->numero_prestamo = $numeroPrestamo;
            $prestamo->user_id = Auth::id();
            $prestamo->estado = 'activo';

            // Convertir valores numéricos a tipos correctos
            $validated['plazo'] = (int) $validated['plazo'];
            $validated['monto_prestado'] = (float) $validated['monto_prestado'];
            $validated['tasa_interes'] = (float) $validated['tasa_interes'];

            // Si viene de una cotización, usar los valores calculados de la cotización
            // NO recalcular para evitar duplicar intereses
            if (!empty($validated['cotizacion_id'])) {
                \Log::info('Préstamo viene de cotización - usando valores de cotización sin recalcular');
                $cotizacionOrigen = Cotizacion::find($validated['cotizacion_id']);

                if ($cotizacionOrigen) {
                    // El monto_prestado ya viene correcto (total - enganche)
                    // Calcular el total y cuota basándose SOLO en el capital, sin sumar intereses adicionales
                    // porque el "total" de la cotización ya consideró todo

                    // Para préstamos desde cotización:
                    // - El monto_prestado es lo que se va a financiar (capital)
                    // - NO recalculamos intereses porque podrían estar incluidos en el precio
                    // - El monto_total será igual al monto_prestado (sin agregar más intereses)
                    // - La cuota simplemente divide el monto entre el plazo

                    $prestamo->interes_total = 0; // No agregar más intereses
                    $prestamo->monto_total = $validated['monto_prestado']; // El total es el monto a financiar
                    $prestamo->monto_cuota = $validated['monto_prestado'] / $validated['plazo'];
                    $prestamo->saldo_pendiente = $prestamo->monto_total;

                    \Log::info('Valores del préstamo desde cotización:');
                    \Log::info('- Monto prestado: ' . $prestamo->monto_prestado);
                    \Log::info('- Interés total: ' . $prestamo->interes_total);
                    \Log::info('- Monto total: ' . $prestamo->monto_total);
                    \Log::info('- Cuota: ' . $prestamo->monto_cuota);
                }
            } else {
                \Log::info('Calculando valores del préstamo normalmente');
                // Calcular valores del préstamo normalmente (con intereses)
                $prestamo->calcularValores();
            }

            \Log::info('Calculando fechas de pago');
            // Calcular fecha del primer pago
            $fechaDesembolso = Carbon::parse($validated['fecha_desembolso']);
            switch ($validated['frecuencia_pago']) {
                case 'semanal':
                    $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addWeek();
                    $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addWeeks($validated['plazo']);
                    break;
                case 'quincenal':
                    $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addWeeks(2);
                    $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addWeeks($validated['plazo'] * 2);
                    break;
                case 'mensual':
                    $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addMonth();
                    $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addMonths($validated['plazo']);
                    break;
            }

            \Log::info('Guardando préstamo en DB');
            $prestamo->save();
            \Log::info('Préstamo guardado con ID: ' . $prestamo->id);

            // Si el préstamo viene de una cotización, actualizar la relación bidireccional
            if (!empty($validated['cotizacion_id'])) {
                \Log::info('Actualizando relación con cotización ID: ' . $validated['cotizacion_id']);
                $cotizacion = Cotizacion::find($validated['cotizacion_id']);
                if ($cotizacion) {
                    $cotizacion->prestamo_id = $prestamo->id;
                    $cotizacion->estado = 'convertida';
                    $cotizacion->save();
                    \Log::info('Cotización actualizada con préstamo ID: ' . $prestamo->id);
                }
            }

            // Crear aportaciones si se especificaron
            if (!empty($validated['aportadores'])) {
                \Log::info('Creando aportaciones');
                foreach ($validated['aportadores'] as $aportacionData) {
                    if (empty($aportacionData['id']) || empty($aportacionData['monto'])) {
                        continue;
                    }

                    $montoAportado = (float) $aportacionData['monto'];
                    $porcentaje = ($montoAportado / $prestamo->monto_prestado) * 100;

                    \Log::info("Creando aportación para aportador {$aportacionData['id']}: Q{$montoAportado}");

                    // Crear la aportación
                    Aportacion::create([
                        'aportador_id' => $aportacionData['id'],
                        'prestamo_id' => $prestamo->id,
                        'monto_aportado' => $montoAportado,
                        'porcentaje_participacion' => $porcentaje,
                        'saldo_pendiente' => $montoAportado,
                        'monto_recuperado' => 0,
                        'intereses_ganados' => 0,
                        'fecha_aportacion' => now(),
                        'estado' => 'Activo',
                    ]);

                    // Actualizar el capital del aportador
                    $aportador = Aportador::find($aportacionData['id']);
                    $aportador->capital_disponible -= $montoAportado;
                    $aportador->capital_invertido += $montoAportado;
                    $aportador->save();

                    \Log::info("Aportador actualizado - Disponible: {$aportador->capital_disponible}, Invertido: {$aportador->capital_invertido}");
                }
            }

            \Log::info('Commit de transacción');
            DB::commit();

            \Log::info('Redirigiendo a prestamos.show con ID: ' . $prestamo->id);
            return redirect()->route('prestamos.show', $prestamo)
                ->with('success', 'Préstamo creado exitosamente y fondeado por los aportadores.');

        } catch (\Exception $e) {
            \Log::error('Error al crear préstamo: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Error al crear el préstamo: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo->load(['cliente', 'usuario', 'aprobador', 'pagos.usuario', 'aportaciones.aportador', 'cotizacion']);

        // Generar tabla de amortización
        $tablaAmortizacion = $prestamo->generarTablaAmortizacion();

        return view('prestamos.show-flowbite', compact('prestamo', 'tablaAmortizacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamo $prestamo)
    {
        // Solo permitir editar préstamos pendientes
        if ($prestamo->estado !== 'pendiente' && $prestamo->estado !== 'activo') {
            return back()->with('error', 'No se puede editar este préstamo.');
        }

        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre_completo')->get();

        return view('prestamos.edit-flowbite', compact('prestamo', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        // Solo permitir actualizar si no tiene pagos
        if ($prestamo->pagos()->exists()) {
            return back()->with('error', 'No se puede editar un préstamo que ya tiene pagos registrados.');
        }

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'monto_prestado' => 'required|numeric|min:500|max:100000',
            'tasa_interes' => 'required|numeric|min:0|max:100',
            'tipo_interes' => 'required|in:simple,compuesto',
            'plazo' => 'required|integer|min:1|max:60',
            'frecuencia_pago' => 'required|in:semanal,quincenal,mensual',
            'fecha_desembolso' => 'required|date',
            'tipo_garantia' => 'required|in:ninguna,prenda,hipoteca,fiador,otro',
            'descripcion_garantia' => 'nullable|string',
            'estado' => 'required|in:pendiente,activo,cancelado',
            'notas' => 'nullable|string',
        ]);

        $prestamo->fill($validated);

        // Convertir valores numéricos a tipos correctos
        $validated['plazo'] = (int) $validated['plazo'];
        $validated['monto_prestado'] = (float) $validated['monto_prestado'];
        $validated['tasa_interes'] = (float) $validated['tasa_interes'];

        $prestamo->calcularValores();

        // Recalcular fechas
        $fechaDesembolso = Carbon::parse($validated['fecha_desembolso']);
        switch ($validated['frecuencia_pago']) {
            case 'semanal':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addWeek();
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addWeeks($validated['plazo']);
                break;
            case 'quincenal':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addWeeks(2);
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addWeeks($validated['plazo'] * 2);
                break;
            case 'mensual':
                $prestamo->fecha_primer_pago = $fechaDesembolso->copy()->addMonth();
                $prestamo->fecha_ultimo_pago = $fechaDesembolso->copy()->addMonths($validated['plazo']);
                break;
        }

        $prestamo->save();

        return redirect()->route('prestamos.show', $prestamo)
            ->with('success', 'Préstamo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo, Request $request)
    {
        $forzarEliminacion = $request->input('forzar_eliminacion') === 'true';

        // Contar registros relacionados
        $countPagos = $prestamo->pagos()->count();
        $countAportaciones = $prestamo->aportaciones()->count();

        // Si se solicita forzar la eliminación, eliminar todo en cascada
        if ($forzarEliminacion) {
            if (!Auth::user()->hasPermissionTo('eliminar-prestamos')) {
                return back()->with('error', 'No tiene permisos para eliminar préstamos.');
            }

            \DB::beginTransaction();
            try {
                \Log::info("=== ELIMINANDO PRÉSTAMO FORZADO {$prestamo->numero_prestamo} ===");

                // Eliminar distribuciones de pagos
                if ($countPagos > 0) {
                    foreach ($prestamo->pagos as $pago) {
                        \App\Models\DistribucionPago::where('pago_id', $pago->id)->delete();
                    }
                    $prestamo->pagos()->delete();
                    \Log::info("Eliminados {$countPagos} pago(s)");
                }

                // Eliminar aportaciones - IMPORTANTE: iterar para que se dispare el evento boot()
                if ($countAportaciones > 0) {
                    \Log::info("Eliminando {$countAportaciones} aportación(es) y devolviendo dinero a aportadores...");

                    // Cargar las aportaciones con sus aportadores
                    $aportaciones = $prestamo->aportaciones()->with('aportador')->get();

                    // Guardar IDs de aportadores afectados para validación posterior
                    $aportadoresAfectados = $aportaciones->pluck('aportador_id')->unique();

                    foreach ($aportaciones as $aportacion) {
                        \Log::info("=== Eliminando aportación ID {$aportacion->id} ===");
                        \Log::info("Aportador: {$aportacion->aportador_id}, Monto aportado: Q{$aportacion->monto_aportado}, Monto recuperado: Q{$aportacion->monto_recuperado}");

                        // Eliminar individualmente para disparar el evento boot()
                        $aportacion->delete();

                        \Log::info("Aportación ID {$aportacion->id} eliminada exitosamente");
                    }

                    // Validar que los cambios se aplicaron
                    \Log::info("Validando cambios en aportadores...");
                    foreach ($aportadoresAfectados as $aportadorId) {
                        $aportador = \App\Models\Aportador::find($aportadorId);
                        if ($aportador) {
                            \Log::info("Aportador {$aportadorId} - Estado final: Disponible=Q{$aportador->capital_disponible}, Invertido=Q{$aportador->capital_invertido}");
                        }
                    }
                }

                // Revertir estado de cotización si existe
                if ($prestamo->cotizacion_id) {
                    $cotizacion = \App\Models\Cotizacion::find($prestamo->cotizacion_id);
                    if ($cotizacion) {
                        $cotizacion->estado = 'pendiente';
                        $cotizacion->prestamo_id = null;
                        $cotizacion->save();
                        \Log::info("Cotización ID {$cotizacion->id} revertida a estado pendiente");
                    }
                }

                // Eliminar el préstamo
                $prestamo->delete();
                \Log::info("Préstamo {$prestamo->numero_prestamo} eliminado exitosamente");

                \DB::commit();
                \Log::info("Transacción confirmada (commit) exitosamente");

                return redirect()->route('prestamos.index')
                    ->with('success', "Préstamo eliminado exitosamente. Se revirtieron {$countAportaciones} aportación(es) y se eliminaron {$countPagos} pago(s). El dinero ha sido devuelto a los inversionistas.");

            } catch (\Exception $e) {
                \DB::rollback();
                \Log::error('Error al eliminar préstamo: ' . $e->getMessage());
                return back()->with('error', 'Error al eliminar el préstamo: ' . $e->getMessage());
            }
        }

        // Validación normal sin forzar
        if ($countPagos > 0) {
            return back()
                ->with('error', "No se puede eliminar un préstamo que tiene {$countPagos} pago(s) registrado(s).")
                ->with('prestamo_id', $prestamo->id)
                ->with('tiene_pagos', true)
                ->with('count_pagos', $countPagos)
                ->with('count_aportaciones', $countAportaciones);
        }

        // Eliminar aportaciones y devolver dinero a aportadores antes de soft delete
        \DB::beginTransaction();
        try {
            if ($countAportaciones > 0) {
                \Log::info("=== ELIMINANDO PRÉSTAMO {$prestamo->numero_prestamo} (Soft Delete) ===");
                \Log::info("Devolviendo dinero de {$countAportaciones} aportación(es) a inversionistas...");

                // Cargar las aportaciones con sus aportadores
                $aportaciones = $prestamo->aportaciones()->with('aportador')->get();

                // Guardar IDs de aportadores afectados
                $aportadoresAfectados = $aportaciones->pluck('aportador_id')->unique();

                foreach ($aportaciones as $aportacion) {
                    \Log::info("=== Eliminando aportación ID {$aportacion->id} ===");
                    \Log::info("Aportador: {$aportacion->aportador_id}, Monto aportado: Q" . number_format($aportacion->monto_aportado, 2) . ", Monto recuperado: Q" . number_format($aportacion->monto_recuperado, 2));

                    // Eliminar individualmente para disparar el evento boot()
                    $aportacion->delete();

                    \Log::info("Aportación ID {$aportacion->id} eliminada exitosamente");
                }

                // Validar que los cambios se aplicaron
                \Log::info("Validando cambios en aportadores...");
                foreach ($aportadoresAfectados as $aportadorId) {
                    $aportador = \App\Models\Aportador::find($aportadorId);
                    if ($aportador) {
                        \Log::info("Aportador {$aportadorId} - Estado final: Disponible=Q{$aportador->capital_disponible}, Invertido=Q{$aportador->capital_invertido}");
                    }
                }
            }

            // Revertir estado de cotización si existe
            if ($prestamo->cotizacion_id) {
                $cotizacion = \App\Models\Cotizacion::find($prestamo->cotizacion_id);
                if ($cotizacion) {
                    $cotizacion->estado = 'pendiente';
                    $cotizacion->prestamo_id = null;
                    $cotizacion->save();
                    \Log::info("Cotización ID {$cotizacion->id} revertida a estado pendiente");
                }
            }

            // Eliminar el préstamo (soft delete)
            $prestamo->delete();
            \Log::info("Transacción confirmada (commit) exitosamente");

            \DB::commit();

            $mensaje = $countAportaciones > 0
                ? "Préstamo eliminado exitosamente. Se devolvió el dinero de {$countAportaciones} aportación(es) a los inversionistas."
                : 'Préstamo eliminado exitosamente.';

            return redirect()->route('prestamos.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error al eliminar préstamo: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el préstamo: ' . $e->getMessage());
        }
    }

    /**
     * Recalcular aportadores automáticamente (método interno)
     */
    private function recalcularAportadoresAutomatico()
    {
        try {
            $aportadores = \App\Models\Aportador::all();

            foreach ($aportadores as $aportador) {
                $aportacionesActivas = \App\Models\Aportacion::where('aportador_id', $aportador->id)
                    ->whereIn('estado', ['Activo', 'Recuperado'])
                    ->get();

                $aportador->capital_invertido = $aportacionesActivas->sum('monto_aportado');
                $aportador->capital_recuperado = $aportacionesActivas->sum('monto_recuperado');
                $aportador->ganancias_totales = $aportacionesActivas->sum('intereses_ganados');
                $aportador->save();
            }
        } catch (\Exception $e) {
            \Log::error('Error al recalcular aportadores automáticamente: ' . $e->getMessage());
        }
    }

    /**
     * Aprobar un préstamo
     */
    public function aprobar(Prestamo $prestamo)
    {
        if ($prestamo->estado !== 'pendiente') {
            return back()->with('error', 'Este préstamo ya fue procesado.');
        }

        $prestamo->estado = 'activo';
        $prestamo->aprobado_por = Auth::id();
        $prestamo->fecha_aprobacion = now();
        $prestamo->save();

        return back()->with('success', 'Préstamo aprobado exitosamente.');
    }
}
