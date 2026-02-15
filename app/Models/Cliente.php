<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre_completo',
        'dpi',
        'fecha_nacimiento',
        'genero',
        'estado_civil',
        'telefono',
        'telefono_alternativo',
        'email',
        'departamento',
        'municipio',
        'direccion_completa',
        'zona',
        'profesion',
        'lugar_trabajo',
        'puesto_trabajo',
        'ingreso_mensual',
        'referencia_nombre_1',
        'referencia_telefono_1',
        'referencia_parentesco_1',
        'referencia_nombre_2',
        'referencia_telefono_2',
        'referencia_parentesco_2',
        'estado',
        'notas',
        'user_id',
        'portal_user_id',
        'portal_activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'ingreso_mensual' => 'decimal:2',
    ];

    /**
     * Relación con el usuario que registró al cliente
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el usuario del portal del cliente
     */
    public function portalUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'portal_user_id');
    }

    /**
     * Relación con los préstamos del cliente
     */
    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }

    /**
     * Relación con los pagos del cliente
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Relación con los comprobantes de pago del cliente
     */
    public function comprobantes(): HasMany
    {
        return $this->hasMany(ComprobantePago::class);
    }

    /**
     * Relación con los archivos del cliente
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(ClienteArchivo::class);
    }

    /**
     * Relación con las fotos de avance del proyecto
     */
    public function fotosProyecto(): HasMany
    {
        return $this->hasMany(FotoProyecto::class);
    }

    /**
     * Relación con los contratos
     */
    public function contratos(): HasMany
    {
        return $this->hasMany(Contrato::class);
    }

    /**
     * Scope para clientes activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Obtener la edad del cliente
     */
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->age;
    }

    /**
     * Formatear DPI con espacios
     */
    public function getDpiFormateadoAttribute()
    {
        $dpi = preg_replace('/\s+/', '', $this->dpi);
        return substr($dpi, 0, 4) . ' ' . substr($dpi, 4, 5) . ' ' . substr($dpi, 9, 4);
    }

    /**
     * Formatear teléfono
     */
    public function getTelefonoFormateadoAttribute()
    {
        $telefono = preg_replace('/\D/', '', $this->telefono);
        if (strlen($telefono) === 8) {
            return '+502 ' . substr($telefono, 0, 4) . '-' . substr($telefono, 4);
        }
        return $this->telefono;
    }

    /**
     * Obtener total de préstamos activos
     */
    public function getTotalPrestamosActivosAttribute()
    {
        return $this->prestamos()->whereIn('estado', ['activo', 'en_mora', 'vencido'])->count();
    }

    /**
     * Obtener saldo total pendiente
     */
    public function getSaldoTotalPendienteAttribute()
    {
        return $this->prestamos()
            ->whereIn('estado', ['activo', 'en_mora', 'vencido'])
            ->sum('saldo_pendiente');
    }

    /**
     * Verificar si el cliente tiene buen historial
     */
    public function tieneBuenHistorial(): bool
    {
        $totalPrestamos = $this->prestamos()->count();
        if ($totalPrestamos === 0) {
            return true;
        }

        $prestamosVencidos = $this->prestamos()
            ->whereIn('estado', ['vencido', 'en_mora'])
            ->count();

        return ($prestamosVencidos / $totalPrestamos) < 0.3; // Menos del 30% vencidos
    }
}
