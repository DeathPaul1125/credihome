<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContratistaProyecto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contratista_id',
        'nombre_proyecto',
        'descripcion',
        'ubicacion',
        'cliente',
        'tipo_proyecto',
        'monto_proyecto',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'duracion_dias',
        'materiales_utilizados',
        'notas',
    ];

    protected $casts = [
        'monto_proyecto' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'duracion_dias' => 'integer',
    ];

    /**
     * Relación con contratista
     */
    public function contratista()
    {
        return $this->belongsTo(Contratista::class);
    }

    /**
     * Calcular duración en días
     */
    public function calcularDuracion()
    {
        if ($this->fecha_inicio && $this->fecha_fin) {
            $this->duracion_dias = $this->fecha_inicio->diffInDays($this->fecha_fin);
            $this->save();
        }
    }
}
