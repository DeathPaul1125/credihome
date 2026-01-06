<?php

namespace App\Models;

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
            if (empty($prestamo->numero_prestamo)) {
                $prestamo->numero_prestamo = 'P-' . date('Y') . '-' . str_pad(
                    self::whereYear('created_at', date('Y'))->count() + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                );
            }

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
     * Calcular cuota con sistema francés (amortización)
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
     * Calcular valores del préstamo
     */
    public function calcularValores()
    {
        if ($this->tipo_interes === 'simple') {
            $this->interes_total = self::calcularInteresSimple(
                $this->monto_prestado,
                $this->tasa_interes,
                $this->plazo
            );
            $this->monto_total = $this->monto_prestado + $this->interes_total;
            $this->monto_cuota = $this->monto_total / $this->plazo;
        } else {
            $this->monto_cuota = self::calcularCuotaFrances(
                $this->monto_prestado,
                $this->tasa_interes,
                $this->plazo
            );
            $this->monto_total = $this->monto_cuota * $this->plazo;
            $this->interes_total = $this->monto_total - $this->monto_prestado;
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
}
