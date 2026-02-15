<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contrato extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero_contrato',
        'cliente_id',
        'prestamo_id',
        'contratista_id',
        'titulo',
        'contenido',
        'estado',
        'fecha_contrato',
        'fecha_inicio',
        'fecha_fin',
        'monto_contrato',
        'notas',
        'creado_por',
    ];

    protected $casts = [
        'fecha_contrato' => 'date',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'monto_contrato' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function contratista()
    {
        return $this->belongsTo(Contratista::class);
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    public static function generateNumero()
    {
        $year = date('Y');
        $last = self::withTrashed()
            ->where('numero_contrato', 'like', "CTR-{$year}-%")
            ->orderBy('numero_contrato', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->numero_contrato, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'CTR-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
