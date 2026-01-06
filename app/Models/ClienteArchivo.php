<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ClienteArchivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'user_id',
        'nombre_original',
        'nombre_archivo',
        'ruta',
        'mime_type',
        'tamano',
        'extension',
        'descripcion',
    ];

    protected $casts = [
        'tamano' => 'integer',
    ];

    /**
     * Relación con el cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con el usuario que subió el archivo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener la URL del archivo
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->ruta);
    }

    /**
     * Obtener el tamaño formateado del archivo
     */
    public function getTamanoFormateadoAttribute(): string
    {
        $bytes = $this->tamano;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Verificar si es una imagen
     */
    public function getEsImagenAttribute(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Verificar si es un PDF
     */
    public function getEsPdfAttribute(): bool
    {
        return $this->mime_type === 'application/pdf';
    }
}
