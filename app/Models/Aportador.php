<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aportador extends Model
{
    use SoftDeletes;

    protected $table = 'aportadores';

    protected $fillable = [
        'nombre',
        'dpi',
        'email',
        'telefono',
        'direccion',
        'tipo',
        'empresa',
        'nit',
        'capital_disponible',
        'capital_invertido',
        'capital_recuperado',
        'ganancias_totales',
        'tasa_interes_minima',
        'plazo_maximo',
        'monto_minimo_prestamo',
        'monto_maximo_prestamo',
        'estado',
        'notas',
        'usuario_id',
    ];

    protected $casts = [
        'capital_disponible' => 'decimal:2',
        'capital_invertido' => 'decimal:2',
        'capital_recuperado' => 'decimal:2',
        'ganancias_totales' => 'decimal:2',
        'tasa_interes_minima' => 'decimal:2',
        'monto_minimo_prestamo' => 'decimal:2',
        'monto_maximo_prestamo' => 'decimal:2',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function aportaciones()
    {
        return $this->hasMany(Aportacion::class);
    }

    public function aportacionesActivas()
    {
        return $this->hasMany(Aportacion::class)->where('estado', 'Activo');
    }

    public function prestamos()
    {
        return $this->belongsToMany(Prestamo::class, 'aportaciones')
            ->withPivot('monto_aportado', 'porcentaje_participacion', 'monto_recuperado', 'intereses_ganados', 'estado')
            ->withTimestamps();
    }

    public function distribucionesPagos()
    {
        return $this->hasMany(DistribucionPago::class);
    }

    // Métodos auxiliares
    public function puedeAportar($monto)
    {
        return $this->estado === 'Activo' && $this->capital_disponible >= $monto;
    }

    public function getTotalInvertidoAttribute()
    {
        return $this->capital_invertido + $this->capital_recuperado;
    }

    public function getRoiAttribute()
    {
        $totalInvertido = $this->getTotalInvertidoAttribute();
        return $totalInvertido > 0 ? ($this->ganancias_totales / $totalInvertido) * 100 : 0;
    }
}
