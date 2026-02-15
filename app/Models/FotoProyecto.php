<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoProyecto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cliente_id',
        'prestamo_id',
        'titulo',
        'descripcion',
        'ruta_imagen',
        'fecha_avance',
        'porcentaje_avance',
        'estado',
        'aprobado_por',
        'fecha_aprobacion',
        'comentario_admin',
    ];

    protected $casts = [
        'fecha_avance' => 'date',
        'fecha_aprobacion' => 'datetime',
        'porcentaje_avance' => 'decimal:2',
    ];

    /**
     * Relación con Cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con Prestamo
     */
    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    /**
     * Relación con el usuario que aprobó
     */
    public function aprobador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    /**
     * Obtener la URL completa de la imagen
     */
    public function getImagenUrlAttribute(): string
    {
        return asset('storage/' . $this->ruta_imagen);
    }
}
