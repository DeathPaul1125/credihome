<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ContratistaArchivo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'contratista_id',
        'nombre_archivo',
        'tipo_documento',
        'ruta_archivo',
        'mime_type',
        'tamano_kb',
        'descripcion',
        'fecha_vigencia',
        'uploaded_by',
    ];

    protected $casts = [
        'fecha_vigencia' => 'date',
        'tamano_kb' => 'integer',
    ];

    /**
     * Relación con contratista
     */
    public function contratista()
    {
        return $this->belongsTo(Contratista::class);
    }

    /**
     * Relación con usuario que subió el archivo
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Obtener URL completa del archivo
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->ruta_archivo);
    }

    /**
     * Verificar si el documento está vencido
     */
    public function getEstaVencidoAttribute()
    {
        if (!$this->fecha_vigencia) {
            return false;
        }
        return $this->fecha_vigencia->isPast();
    }

    /**
     * Verificar si el documento está por vencer (próximos 30 días)
     */
    public function getEstaPorVencerAttribute()
    {
        if (!$this->fecha_vigencia) {
            return false;
        }
        return $this->fecha_vigencia->isFuture() &&
               $this->fecha_vigencia->diffInDays(now()) <= 30;
    }
}
