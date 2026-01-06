<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero_recibo',
        'prestamo_id',
        'cliente_id',
        'numero_cuota',
        'monto_cuota_esperado',
        'monto_pagado',
        'mora',
        'fecha_vencimiento',
        'fecha_pago',
        'dias_atraso',
        'estado',
        'tipo_pago',
        'saldo_anterior',
        'saldo_nuevo',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'monto_cuota_esperado' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
        'mora' => 'decimal:2',
        'saldo_anterior' => 'decimal:2',
        'saldo_nuevo' => 'decimal:2',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pago) {
            if (empty($pago->numero_recibo)) {
                $pago->numero_recibo = 'R-' . date('Y') . '-' . str_pad(
                    self::whereYear('created_at', date('Y'))->count() + 1,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }

            // Calcular días de atraso
            if ($pago->fecha_pago && $pago->fecha_vencimiento) {
                $dias = $pago->fecha_pago->diffInDays($pago->fecha_vencimiento, false);
                $pago->dias_atraso = $dias < 0 ? abs($dias) : 0;
            }

            // Determinar estado del pago
            if (empty($pago->estado)) {
                if ($pago->dias_atraso > 0) {
                    $pago->estado = 'atrasado';
                } elseif ($pago->monto_pagado < $pago->monto_cuota_esperado) {
                    $pago->estado = 'parcial';
                } elseif ($pago->fecha_pago < $pago->fecha_vencimiento) {
                    $pago->estado = 'anticipado';
                } else {
                    $pago->estado = 'puntual';
                }
            }
        });

        static::created(function ($pago) {
            // Distribuir pago a aportadores PRIMERO
            $pago->distribuirAAportadores();

            // Actualizar el préstamo después de registrar el pago
            $prestamo = $pago->prestamo;
            $prestamo->total_pagado += $pago->monto_pagado;
            $prestamo->saldo_pendiente -= $pago->monto_pagado;
            $prestamo->cuotas_pagadas++;

            if ($pago->estado === 'atrasado') {
                $prestamo->cuotas_vencidas = max(0, $prestamo->cuotas_vencidas - 1);
            }

            // Actualizar estado del préstamo
            if ($prestamo->saldo_pendiente <= 0) {
                $prestamo->estado = 'pagado';
            } elseif ($prestamo->cuotas_vencidas > 2) {
                $prestamo->estado = 'vencido';
            } elseif ($prestamo->cuotas_vencidas > 0) {
                $prestamo->estado = 'en_mora';
            } else {
                $prestamo->estado = 'activo';
            }

            $prestamo->save();
        });
    }

    /**
     * Relación con el préstamo
     */
    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    /**
     * Relación con el cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con el usuario que registró el pago
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con distribuciones de pago
     */
    public function distribucionesPagos()
    {
        return $this->hasMany(DistribucionPago::class);
    }

    /**
     * Distribuir el pago automáticamente entre aportadores
     */
    public function distribuirAAportadores()
    {
        $prestamo = $this->prestamo;

        // Verificar si el préstamo tiene aportadores
        if (!$prestamo->tieneAportadores()) {
            return;
        }

        // Obtener todas las aportaciones activas del préstamo
        $aportaciones = $prestamo->aportaciones()->where('estado', 'Activo')->get();

        if ($aportaciones->isEmpty()) {
            return;
        }

        // Calcular cuánto del pago es capital y cuánto es interés
        // Para simplificar, usamos la cuota completa y calculamos proporción
        $montoPago = $this->monto_pagado;
        $totalCuotas = $prestamo->plazo;
        $cuotaActual = $this->numero_cuota;

        // Cálculo simplificado: proporción de capital vs interés en esta cuota
        // En un sistema francés, las primeras cuotas tienen más interés
        $factorInteres = 1 - ($cuotaActual / $totalCuotas);
        $montoInteresCuota = $montoPago * $factorInteres * 0.5; // Ajustar factor
        $montoCapitalCuota = $montoPago - $montoInteresCuota;

        // Distribuir proporcionalmente a cada aportador
        foreach ($aportaciones as $aportacion) {
            $porcentaje = $aportacion->porcentaje_participacion;

            // Calcular montos para este aportador
            $montoCapital = ($montoCapitalCuota * $porcentaje) / 100;
            $montoInteres = ($montoInteresCuota * $porcentaje) / 100;
            $montoTotal = $montoCapital + $montoInteres;

            // Registrar la distribución
            DistribucionPago::create([
                'pago_id' => $this->id,
                'aportacion_id' => $aportacion->id,
                'aportador_id' => $aportacion->aportador_id,
                'monto_capital' => $montoCapital,
                'monto_interes' => $montoInteres,
                'monto_total' => $montoTotal,
                'porcentaje_aplicado' => $porcentaje,
                'fecha_distribucion' => now(),
            ]);

            // Actualizar la aportación
            $aportacion->monto_recuperado += $montoCapital;
            $aportacion->intereses_ganados += $montoInteres;
            $aportacion->saldo_pendiente -= $montoCapital;

            // Si se recuperó todo, marcar como recuperado
            if ($aportacion->saldo_pendiente <= 0.01) {
                $aportacion->marcarComoRecuperado();
            } else {
                $aportacion->save();
            }

            // Actualizar el aportador
            $aportador = $aportacion->aportador;
            $aportador->capital_recuperado += $montoCapital;
            $aportador->ganancias_totales += $montoInteres;
            $aportador->capital_invertido -= $montoCapital;
            $aportador->capital_disponible += $montoTotal; // Devolver capital + interés
            $aportador->save();
        }
    }

    /**
     * Scope para pagos puntuales
     */
    public function scopePuntuales($query)
    {
        return $query->where('estado', 'puntual');
    }

    /**
     * Scope para pagos atrasados
     */
    public function scopeAtrasados($query)
    {
        return $query->where('estado', 'atrasado');
    }

    /**
     * Calcular mora
     */
    public static function calcularMora($montoCuota, $diasAtraso, $tasaMora = 2.0)
    {
        if ($diasAtraso <= 0) {
            return 0;
        }

        return round($montoCuota * ($tasaMora / 100) * ($diasAtraso / 30), 2);
    }

    /**
     * Formatear monto en Quetzales
     */
    public function getMontoFormateadoAttribute()
    {
        return 'Q ' . number_format($this->monto_pagado, 2, '.', ',');
    }

    /**
     * Obtener badge de estado
     */
    public function getBadgeEstadoAttribute()
    {
        $badges = [
            'puntual' => '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Puntual</span>',
            'atrasado' => '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Atrasado</span>',
            'parcial' => '<span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Parcial</span>',
            'anticipado' => '<span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Anticipado</span>',
        ];

        return $badges[$this->estado] ?? '';
    }
}
