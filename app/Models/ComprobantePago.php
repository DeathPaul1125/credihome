<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComprobantePago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comprobantes_pago';

    protected $fillable = [
        'prestamo_id',
        'cliente_id',
        'numero_comprobante',
        'monto_pagado',
        'fecha_pago',
        'archivo_comprobante',
        'metodo_pago',
        'numero_referencia',
        'observaciones',
        'estado',
        'validado_por',
        'fecha_validacion',
        'motivo_rechazo',
        'pago_id',
    ];

    protected $casts = [
        'monto_pagado' => 'decimal:2',
        'fecha_pago' => 'date',
        'fecha_validacion' => 'datetime',
    ];

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comprobante) {
            if (empty($comprobante->numero_comprobante)) {
                $comprobante->numero_comprobante = 'COMP-' . date('Y') . '-' . str_pad(
                    self::whereYear('created_at', date('Y'))->count() + 1,
                    6,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    /**
     * Relación con préstamo
     */
    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    /**
     * Relación con cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con validador
     */
    public function validador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validado_por');
    }

    /**
     * Relación con pago generado
     */
    public function pago(): BelongsTo
    {
        return $this->belongsTo(Pago::class);
    }

    /**
     * Scope para comprobantes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para comprobantes aprobados
     */
    public function scopeAprobados($query)
    {
        return $query->where('estado', 'aprobado');
    }

    /**
     * Verificar si está pendiente
     */
    public function isPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    /**
     * Verificar si está aprobado
     */
    public function isAprobado(): bool
    {
        return $this->estado === 'aprobado';
    }

    /**
     * Verificar si está rechazado
     */
    public function isRechazado(): bool
    {
        return $this->estado === 'rechazado';
    }
}
