<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribucionPago extends Model
{
    protected $table = 'distribucion_pagos';

    protected $fillable = [
        'pago_id',
        'aportacion_id',
        'aportador_id',
        'monto_capital',
        'monto_interes',
        'monto_total',
        'porcentaje_aplicado',
        'fecha_distribucion',
    ];

    protected $casts = [
        'monto_capital' => 'decimal:2',
        'monto_interes' => 'decimal:2',
        'monto_total' => 'decimal:2',
        'porcentaje_aplicado' => 'decimal:2',
        'fecha_distribucion' => 'datetime',
    ];

    // Relaciones
    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }

    public function aportacion()
    {
        return $this->belongsTo(Aportacion::class);
    }

    public function aportador()
    {
        return $this->belongsTo(Aportador::class);
    }
}
