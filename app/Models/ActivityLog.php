<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Registrar una actividad
     */
    public static function log(string $description, $subject = null, array $properties = [], string $logName = 'default')
    {
        return self::create([
            'log_name' => $logName,
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'causer_type' => auth()->check() ? get_class(auth()->user()) : null,
            'causer_id' => auth()->id(),
            'properties' => $properties,
        ]);
    }

    /**
     * Relación con el causante (usuario)
     */
    public function causer()
    {
        return $this->morphTo();
    }

    /**
     * Relación con el sujeto (modelo afectado)
     */
    public function subject()
    {
        return $this->morphTo();
    }
}
