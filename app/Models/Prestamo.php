<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Prestamo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero_prestamo',
        'cliente_id',
        'cotizacion_id',
        'monto_prestado',
        'tasa_interes',
        'tipo_interes',
        'plazo',
        'frecuencia_pago',
        'interes_total',
        'monto_total',
        'monto_cuota',
        'fecha_desembolso',
        'fecha_primer_pago',
        'fecha_ultimo_pago',
        'tipo_garantia',
        'descripcion_garantia',
        'estado',
        'saldo_pendiente',
        'total_pagado',
        'cuotas_pagadas',
        'cuotas_vencidas',
        'notas',
        'user_id',
        'aprobado_por',
        'fecha_aprobacion',
    ];

    protected $casts = [
        'monto_prestado' => 'decimal:2',
        'tasa_interes' => 'decimal:2',
        'interes_total' => 'decimal:2',
        'monto_total' => 'decimal:2',
        'monto_cuota' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
        'total_pagado' => 'decimal:2',
        'fecha_desembolso' => 'date',
        'fecha_primer_pago' => 'date',
        'fecha_ultimo_pago' => 'date',
        'fecha_aprobacion' => 'datetime',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($prestamo) {
            // Calcular valores si no están definidos
            if (empty($prestamo->saldo_pendiente)) {
                $prestamo->saldo_pendiente = $prestamo->monto_total;
            }
        });
    }

    /**
     * Relación con el cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con la cotización origen (si fue generado desde una cotización)
     */
    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
    }

    /**
     * Relación con el usuario creador
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el usuario aprobador
     */
    public function aprobador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    /**
     * Relación con los pagos
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Relación con comprobantes de pago
     */
    public function comprobantes(): HasMany
    {
        return $this->hasMany(ComprobantePago::class);
    }

    /**
     * Relación con aportadores (muchos a muchos a través de aportaciones)
     */
    public function aportadores()
    {
        return $this->belongsToMany(Aportador::class, 'aportaciones')
            ->withPivot('monto_aportado', 'porcentaje_participacion', 'monto_recuperado', 'intereses_ganados', 'saldo_pendiente', 'estado')
            ->withTimestamps();
    }

    /**
     * Relación con aportaciones
     */
    public function aportaciones()
    {
        return $this->hasMany(Aportacion::class);
    }

    /**
     * Verificar si el préstamo tiene aportadores
     */
    public function tieneAportadores()
    {
        return $this->aportaciones()->exists();
    }

    /**
     * Obtener monto total fondeado por aportadores
     */
    public function getMontoFondeadoAttribute()
    {
        return $this->aportaciones()->sum('monto_aportado');
    }

    /**
     * Verificar si el préstamo está completamente fondeado
     */
    public function estaCompletamenteFondeado()
    {
        return $this->getMontoFondeadoAttribute() >= $this->monto_prestado;
    }

    /**
     * Obtener monto faltante para fondear
     */
    public function getMontoFaltanteFondeoAttribute()
    {
        return max(0, $this->monto_prestado - $this->getMontoFondeadoAttribute());
    }

    /**
     * Scope para préstamos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para préstamos vencidos
     */
    public function scopeVencidos($query)
    {
        return $query->whereIn('estado', ['vencido', 'en_mora']);
    }

    /**
     * Calcular interés simple
     */
    public static function calcularInteresSimple($monto, $tasa, $plazo)
    {
        return $monto * ($tasa / 100) * $plazo;
    }

    /**
     * Calcular cuota con sistema francés (amortización) - Cuota Fija
     */
    public static function calcularCuotaFrances($monto, $tasa, $plazo)
    {
        $tasaPorPeriodo = ($tasa / 100);
        if ($tasaPorPeriodo == 0) {
            return $monto / $plazo;
        }

        $cuota = $monto * (
            ($tasaPorPeriodo * pow(1 + $tasaPorPeriodo, $plazo)) /
            (pow(1 + $tasaPorPeriodo, $plazo) - 1)
        );

        return round($cuota, 2);
    }

    /**
     * Calcular interés con tasa flat
     * El interés se calcula sobre el capital original y se divide en cuotas iguales
     */
    public static function calcularInteresFlat($monto, $tasa, $plazo)
    {
        // Interés total = Capital * Tasa * Plazo
        return $monto * ($tasa / 100) * $plazo;
    }

    /**
     * Calcular tabla de amortización con tasa sobre saldos
     * Retorna array con detalles de cada cuota
     */
    public static function calcularAmortizacionSobreSaldos($monto, $tasa, $plazo)
    {
        $saldo = $monto;
        $tasaPorPeriodo = $tasa / 100;
        $tabla = [];
        
        // Calcular capital fijo por período
        $capitalPorCuota = $monto / $plazo;
        
        for ($i = 1; $i <= $plazo; $i++) {
            $interes = $saldo * $tasaPorPeriodo;
            $cuota = $capitalPorCuota + $interes;
            $saldo -= $capitalPorCuota;
            
            $tabla[] = [
                'numero' => $i,
                'saldo_inicial' => $saldo + $capitalPorCuota,
                'capital' => $capitalPorCuota,
                'interes' => round($interes, 2),
                'cuota' => round($cuota, 2),
                'saldo_final' => max(0, round($saldo, 2))
            ];
        }
        
        return $tabla;
    }

    /**
     * Calcular valores del préstamo
     */
    public function calcularValores()
    {
        switch ($this->tipo_interes) {
            case 'simple':
                // Interés simple: interés se calcula sobre el capital original
                $this->interes_total = self::calcularInteresSimple(
                    $this->monto_prestado,
                    $this->tasa_interes,
                    $this->plazo
                );
                $this->monto_total = $this->monto_prestado + $this->interes_total;
                $this->monto_cuota = $this->monto_total / $this->plazo;
                break;

            case 'compuesto':
            case 'cuota_fija':
                // Sistema Francés: cuota fija con amortización
                $this->monto_cuota = self::calcularCuotaFrances(
                    $this->monto_prestado,
                    $this->tasa_interes,
                    $this->plazo
                );
                $this->monto_total = $this->monto_cuota * $this->plazo;
                $this->interes_total = $this->monto_total - $this->monto_prestado;
                break;

            case 'flat':
                // Tasa Flat: interés se calcula sobre capital original y se divide en cuotas iguales
                $this->interes_total = self::calcularInteresFlat(
                    $this->monto_prestado,
                    $this->tasa_interes,
                    $this->plazo
                );
                $this->monto_total = $this->monto_prestado + $this->interes_total;
                $this->monto_cuota = $this->monto_total / $this->plazo;
                break;

            case 'sobre_saldos':
                // Sobre Saldos: interés se calcula sobre el saldo pendiente (cuota variable)
                $tabla = self::calcularAmortizacionSobreSaldos(
                    $this->monto_prestado,
                    $this->tasa_interes,
                    $this->plazo
                );
                
                // Calcular totales
                $this->interes_total = array_sum(array_column($tabla, 'interes'));
                $this->monto_total = $this->monto_prestado + $this->interes_total;
                
                // Para sobre saldos, monto_cuota es la primera cuota (la más alta)
                // O podemos usar el promedio
                $this->monto_cuota = array_sum(array_column($tabla, 'cuota')) / $this->plazo;
                break;

            default:
                // Por defecto usar cuota fija
                $this->monto_cuota = self::calcularCuotaFrances(
                    $this->monto_prestado,
                    $this->tasa_interes,
                    $this->plazo
                );
                $this->monto_total = $this->monto_cuota * $this->plazo;
                $this->interes_total = $this->monto_total - $this->monto_prestado;
                break;
        }

        $this->saldo_pendiente = $this->monto_total;
    }

    /**
     * Obtener porcentaje de pago
     */
    public function getPorcentajePagadoAttribute()
    {
        if ($this->monto_total == 0) {
            return 0;
        }
        return round(($this->total_pagado / $this->monto_total) * 100, 2);
    }

    /**
     * Verificar si está en mora
     */
    public function estaEnMora(): bool
    {
        return $this->cuotas_vencidas > 0;
    }

    /**
     * Formatear monto en Quetzales
     */
    public function getMontoFormateadoAttribute()
    {
        return 'Q ' . number_format($this->monto_prestado, 2, '.', ',');
    }

    /**
     * Formatear saldo pendiente
     */
    public function getSaldoFormateadoAttribute()
    {
        return 'Q ' . number_format($this->saldo_pendiente, 2, '.', ',');
    }

    /**
     * Generar tabla de amortización completa
     */
    public function generarTablaAmortizacion()
    {
        $tabla = [];

        // Si viene de cotización y no tiene interés total, usar cálculo de cotización
        if ($this->cotizacion_id && $this->interes_total == 0) {
            return $this->generarTablaDesdeCoitizacion();
        }

        $saldo = $this->monto_prestado;
        $tasaPeriodo = $this->tasa_interes / 100;

        // Obtener pagos realizados
        $pagosRealizados = $this->pagos()
            ->orderBy('fecha_pago')
            ->get()
            ->keyBy(function ($pago) {
                return $pago->numero_cuota ?? 0;
            });

        // Calcular fecha de primera cuota según frecuencia
        $fechaCuota = Carbon::parse($this->fecha_desembolso);
        switch ($this->frecuencia_pago) {
            case 'semanal':
                $fechaCuota->addWeek();
                break;
            case 'quincenal':
                $fechaCuota->addWeeks(2);
                break;
            case 'mensual':
            default:
                $fechaCuota->addMonth();
                break;
        }

        for ($i = 1; $i <= $this->plazo; $i++) {
            if ($this->tipo_interes === 'simple') {
                // Interés simple: el interés se calcula sobre el monto original
                $interes = $this->monto_prestado * $tasaPeriodo;
                $capital = $this->monto_cuota - $interes;
            } else {
                // Interés compuesto (sistema francés): el interés se calcula sobre el saldo
                $interes = $saldo * $tasaPeriodo;
                $capital = $this->monto_cuota - $interes;
            }

            $saldoAnterior = $saldo;
            $saldo = max(0, $saldo - $capital);

            // Verificar si existe pago para esta cuota
            $pagoRealizado = $pagosRealizados->get($i);
            $estado = 'pendiente';
            $fechaPago = null;

            if ($pagoRealizado) {
                $estado = 'pagada';
                $fechaPago = $pagoRealizado->fecha_pago;
            } elseif ($fechaCuota->isPast()) {
                $estado = 'vencida';
            }

            $tabla[] = [
                'numero_cuota' => $i,
                'fecha_vencimiento' => $fechaCuota->copy(),
                'fecha_pago' => $fechaPago,
                'cuota' => round($this->monto_cuota, 2),
                'capital' => round($capital, 2),
                'interes' => round($interes, 2),
                'saldo_anterior' => round($saldoAnterior, 2),
                'saldo' => round($saldo, 2),
                'estado' => $estado,
                'pago_id' => $pagoRealizado ? $pagoRealizado->id : null,
                'numero_recibo' => $pagoRealizado ? $pagoRealizado->numero_recibo : null,
            ];

            // Avanzar fecha según frecuencia
            switch ($this->frecuencia_pago) {
                case 'semanal':
                    $fechaCuota->addWeek();
                    break;
                case 'quincenal':
                    $fechaCuota->addWeeks(2);
                    break;
                case 'mensual':
                default:
                    $fechaCuota->addMonth();
                    break;
            }
        }

        return $tabla;
    }

    /**
     * Generar tabla de amortización basada en cotización
     * Usa el mismo cálculo que las cotizaciones (sistema francés)
     */
    private function generarTablaDesdeCoitizacion()
    {
        $tabla = [];

        // Cargar cotización para obtener tasa de interés original
        $cotizacion = $this->cotizacion;
        if (!$cotizacion || !$cotizacion->tasa_interes_anual) {
            // Si no hay cotización o no tiene tasa, usar distribución simple
            return $this->generarTablaSimple();
        }

        // Usar el mismo cálculo que la cotización (sistema francés)
        $tasaMensual = $cotizacion->tasa_interes_anual / 12 / 100;
        $monto = $this->monto_prestado;

        // Calcular cuota mensual usando fórmula francesa
        $cuotaMensual = $monto * ($tasaMensual * pow(1 + $tasaMensual, $this->plazo)) / (pow(1 + $tasaMensual, $this->plazo) - 1);

        $saldoRestante = $monto;

        // Obtener pagos realizados
        $pagosRealizados = $this->pagos()
            ->orderBy('fecha_pago')
            ->get()
            ->keyBy(function ($pago) {
                return $pago->numero_cuota ?? 0;
            });

        // Calcular fecha de primera cuota
        $fechaCuota = Carbon::parse($this->fecha_desembolso);
        switch ($this->frecuencia_pago) {
            case 'semanal':
                $fechaCuota->addWeek();
                break;
            case 'quincenal':
                $fechaCuota->addWeeks(2);
                break;
            case 'mensual':
            default:
                $fechaCuota->addMonth();
                break;
        }

        for ($i = 1; $i <= $this->plazo; $i++) {
            $interesMes = $saldoRestante * $tasaMensual;
            $capitalMes = $cuotaMensual - $interesMes;
            $saldoAnterior = $saldoRestante;
            $saldoRestante -= $capitalMes;

            // Ajustar última cuota por redondeo
            if ($i == $this->plazo && $saldoRestante != 0) {
                $capitalMes += $saldoRestante;
                $saldoRestante = 0;
            }

            // Verificar estado del pago
            $pagoRealizado = $pagosRealizados->get($i);
            $estado = 'pendiente';
            $fechaPago = null;

            if ($pagoRealizado) {
                $estado = 'pagada';
                $fechaPago = $pagoRealizado->fecha_pago;
            } elseif ($fechaCuota->isPast()) {
                $estado = 'vencida';
            }

            $tabla[] = [
                'numero_cuota' => $i,
                'fecha_vencimiento' => $fechaCuota->copy(),
                'fecha_pago' => $fechaPago,
                'cuota' => round($cuotaMensual, 2),
                'capital' => round($capitalMes, 2),
                'interes' => round($interesMes, 2),
                'saldo_anterior' => round($saldoAnterior, 2),
                'saldo' => round($saldoRestante, 2),
                'estado' => $estado,
                'pago_id' => $pagoRealizado ? $pagoRealizado->id : null,
                'numero_recibo' => $pagoRealizado ? $pagoRealizado->numero_recibo : null,
            ];

            // Avanzar fecha
            switch ($this->frecuencia_pago) {
                case 'semanal':
                    $fechaCuota->addWeek();
                    break;
                case 'quincenal':
                    $fechaCuota->addWeeks(2);
                    break;
                case 'mensual':
                default:
                    $fechaCuota->addMonth();
                    break;
            }
        }

        return $tabla;
    }

    /**
     * Generar tabla simple sin intereses (fallback)
     */
    private function generarTablaSimple()
    {
        $tabla = [];
        $cuotaFija = $this->monto_prestado / $this->plazo;
        $saldo = $this->monto_prestado;

        // Obtener pagos realizados
        $pagosRealizados = $this->pagos()
            ->orderBy('fecha_pago')
            ->get()
            ->keyBy(function ($pago) {
                return $pago->numero_cuota ?? 0;
            });

        $fechaCuota = Carbon::parse($this->fecha_desembolso);
        switch ($this->frecuencia_pago) {
            case 'semanal':
                $fechaCuota->addWeek();
                break;
            case 'quincenal':
                $fechaCuota->addWeeks(2);
                break;
            case 'mensual':
            default:
                $fechaCuota->addMonth();
                break;
        }

        for ($i = 1; $i <= $this->plazo; $i++) {
            $saldoAnterior = $saldo;
            $saldo -= $cuotaFija;

            $pagoRealizado = $pagosRealizados->get($i);
            $estado = 'pendiente';
            $fechaPago = null;

            if ($pagoRealizado) {
                $estado = 'pagada';
                $fechaPago = $pagoRealizado->fecha_pago;
            } elseif ($fechaCuota->isPast()) {
                $estado = 'vencida';
            }

            $tabla[] = [
                'numero_cuota' => $i,
                'fecha_vencimiento' => $fechaCuota->copy(),
                'fecha_pago' => $fechaPago,
                'cuota' => round($cuotaFija, 2),
                'capital' => round($cuotaFija, 2),
                'interes' => 0,
                'saldo_anterior' => round($saldoAnterior, 2),
                'saldo' => round(max(0, $saldo), 2),
                'estado' => $estado,
                'pago_id' => $pagoRealizado ? $pagoRealizado->id : null,
                'numero_recibo' => $pagoRealizado ? $pagoRealizado->numero_recibo : null,
            ];

            switch ($this->frecuencia_pago) {
                case 'semanal':
                    $fechaCuota->addWeek();
                    break;
                case 'quincenal':
                    $fechaCuota->addWeeks(2);
                    break;
                case 'mensual':
                default:
                    $fechaCuota->addMonth();
                    break;
            }
        }

        return $tabla;
    }
}
