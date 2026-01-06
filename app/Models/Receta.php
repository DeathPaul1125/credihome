<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_vivienda',
        'area_construccion',
        'costo_total',
        'es_plantilla',
        'cliente_id',
        'estado',
        'notas',
        'user_id',
    ];

    protected $casts = [
        'area_construccion' => 'decimal:2',
        'costo_total' => 'decimal:2',
        'es_plantilla' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function items()
    {
        return $this->hasMany(RecetaItem::class);
    }

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }
}
