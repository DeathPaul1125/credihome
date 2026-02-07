<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model
{
    use SoftDeletes;

    protected $table = 'cotizaciones';

    protected $fillable = [
        'numero_cotizacion',
        'cliente_id',
        'receta_id',
        'fecha_emision',
        'fecha_vencimiento',
        'subtotal',
        'descuento',
        'total',
        'plazo_meses',
        'tasa_interes_anual',
        'enganche',
        'estado',
        'prestamo_id',
        'notas',
        'terminos_condiciones',
        'user_id',
        'aprobada_en',
        'aprobada_por',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_vencimiento' => 'date',
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
        'tasa_interes_anual' => 'decimal:2',
        'enganche' => 'decimal:2',
        'aprobada_en' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function items()
    {
        return $this->hasMany(CotizacionItem::class);
    }

    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobada_por');
    }
}
