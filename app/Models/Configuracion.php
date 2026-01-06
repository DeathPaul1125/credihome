<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';

    protected $fillable = [
        'nombre_aplicacion',
        'slogan',
        'telefono',
        'email',
        'direccion',
        'logo_login',
        'logo_sidebar',
        'logo_reportes',
        'favicon',
        'pdf_orientacion',
        'pdf_tamano',
        'pdf_mostrar_logo',
        'pdf_mostrar_fecha',
        'pdf_mostrar_usuario',
        'pdf_footer',
        'pdf_terminos_condiciones',
        'color_primario',
        'color_secundario',
        'tasa_interes_default',
        'plazo_default',
        'dias_vencimiento_cotizacion',
        'moneda',
        'moneda_nombre',
        'notificar_stock_bajo',
        'notificar_pagos_pendientes',
        'notificar_cotizaciones_vencidas',
    ];

    protected $casts = [
        'pdf_mostrar_logo' => 'boolean',
        'pdf_mostrar_fecha' => 'boolean',
        'pdf_mostrar_usuario' => 'boolean',
        'tasa_interes_default' => 'decimal:2',
        'notificar_stock_bajo' => 'boolean',
        'notificar_pagos_pendientes' => 'boolean',
        'notificar_cotizaciones_vencidas' => 'boolean',
    ];

    /**
     * Obtener la configuración (singleton)
     */
    public static function obtener()
    {
        return self::first() ?? self::create([
            'nombre_aplicacion' => 'CrediHome',
            'moneda' => 'Q',
            'moneda_nombre' => 'Quetzales',
        ]);
    }
}
