<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contratista extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'codigo',
        'nombre_completo',
        'nombre_empresa',
        'dpi',
        'nit',
        'direccion',
        'municipio',
        'departamento',
        'telefono1',
        'telefono2',
        'email',
        'especialidad',
        'tipo_servicio',
        'servicios_ofrecidos',
        'anos_experiencia',
        'calificacion',
        'notas',
        'estado',
    ];

    protected $casts = [
        'anos_experiencia' => 'integer',
        'calificacion' => 'decimal:2',
    ];

    /**
     * Relación con proyectos
     */
    public function proyectos()
    {
        return $this->hasMany(ContratistaProyecto::class);
    }

    /**
     * Relación con archivos
     */
    public function archivos()
    {
        return $this->hasMany(ContratistaArchivo::class);
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    /**
     * Generar código automático
     */
    public static function generateCodigo()
    {
        $year = date('Y');
        $lastContratista = self::withTrashed()
            ->where('codigo', 'like', "CONT-{$year}-%")
            ->orderBy('codigo', 'desc')
            ->first();

        if ($lastContratista) {
            $lastNumber = (int) substr($lastContratista->codigo, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'CONT-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Obtener proyectos completados
     */
    public function proyectosCompletados()
    {
        return $this->proyectos()->where('estado', 'completado');
    }

    /**
     * Obtener proyectos activos
     */
    public function proyectosActivos()
    {
        return $this->proyectos()->whereIn('estado', ['planificacion', 'en_proceso']);
    }
}
