<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'unidad_medida',
        'precio_unitario',
        'stock_actual',
        'stock_minimo',
        'categoria',
        'marca',
        'estado',
        'notas',
        'user_id',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recetaItems(): HasMany
    {
        return $this->hasMany(RecetaItem::class);
    }

    public function cotizacionItems(): HasMany
    {
        return $this->hasMany(CotizacionItem::class);
    }
}
