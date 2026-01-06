<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aportacion extends Model
{
    protected $table = 'aportaciones';

    protected $fillable = [
        'aportador_id',
        'prestamo_id',
        'monto_aportado',
        'porcentaje_participacion',
        'monto_recuperado',
        'intereses_ganados',
        'saldo_pendiente',
        'fecha_aportacion',
        'fecha_recuperacion_completa',
        'estado',
        'notas',
    ];

    protected $casts = [
        'monto_aportado' => 'decimal:2',
        'porcentaje_participacion' => 'decimal:2',
        'monto_recuperado' => 'decimal:2',
        'intereses_ganados' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
        'fecha_aportacion' => 'date',
        'fecha_recuperacion_completa' => 'date',
    ];

    // Relaciones
    public function aportador()
    {
        return $this->belongsTo(Aportador::class);
    }

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function distribucionesPagos()
    {
        return $this->hasMany(DistribucionPago::class);
    }

    // Métodos auxiliares
    public function getPorcentajeRecuperadoAttribute()
    {
        return $this->monto_aportado > 0 ? ($this->monto_recuperado / $this->monto_aportado) * 100 : 0;
    }

    public function getRoiAttribute()
    {
        return $this->monto_aportado > 0 ? ($this->intereses_ganados / $this->monto_aportado) * 100 : 0;
    }

    public function marcarComoRecuperado()
    {
        $this->update([
            'estado' => 'Recuperado',
            'fecha_recuperacion_completa' => now(),
            'saldo_pendiente' => 0,
        ]);
    }
}
