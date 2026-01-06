<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaItem extends Model
{
    protected $fillable = [
        'receta_id',
        'producto_id',
        'cantidad',
        'unidad',
        'precio_unitario',
        'subtotal',
        'notas',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
