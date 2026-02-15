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

    protected static function boot()
    {
        parent::boot();

        // Evento al eliminar una aportación
        static::deleting(function ($aportacion) {
            $aportador = $aportacion->aportador;

            if ($aportador) {
                \Log::info("[BOOT EVENT] ANTES - Aportador {$aportador->id}: Disponible=Q{$aportador->capital_disponible}, Invertido=Q{$aportador->capital_invertido}, Recuperado=Q{$aportador->capital_recuperado}");
                \Log::info("[BOOT EVENT] Eliminando aportación: Monto=Q{$aportacion->monto_aportado}, Recuperado=Q{$aportacion->monto_recuperado}, Intereses=Q{$aportacion->intereses_ganados}");

                // Calcular capital pendiente a devolver (lo que se invirtió menos lo ya recuperado)
                $capitalPendiente = $aportacion->monto_aportado - $aportacion->monto_recuperado;

                // Revertir capital invertido
                $aportador->capital_invertido -= $aportacion->monto_aportado;

                // Devolver capital disponible (solo lo que no se recuperó aún)
                $aportador->capital_disponible += $capitalPendiente;

                // Revertir capital recuperado
                $aportador->capital_recuperado -= $aportacion->monto_recuperado;

                // Revertir ganancias (intereses)
                $aportador->ganancias_totales -= $aportacion->intereses_ganados;

                // Asegurar que no queden valores negativos
                $aportador->capital_invertido = max(0, $aportador->capital_invertido);
                $aportador->capital_recuperado = max(0, $aportador->capital_recuperado);
                $aportador->ganancias_totales = max(0, $aportador->ganancias_totales);
                $aportador->capital_disponible = max(0, $aportador->capital_disponible);

                $aportador->save();

                // Forzar recarga para confirmar cambios
                $aportador->refresh();

                \Log::info("[BOOT EVENT] DESPUÉS - Aportador {$aportador->id}: Disponible=Q{$aportador->capital_disponible}, Invertido=Q{$aportador->capital_invertido}, Recuperado=Q{$aportador->capital_recuperado}, Capital devuelto=Q{$capitalPendiente}");
            }
        });
    }

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
