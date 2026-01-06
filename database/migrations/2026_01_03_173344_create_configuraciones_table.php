<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            // Información General
            $table->string('nombre_aplicacion')->default('CrediHome');
            $table->string('slogan')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->text('direccion')->nullable();

            // Imágenes
            $table->string('logo_login')->nullable(); // Logo para pantalla de login
            $table->string('logo_sidebar')->nullable(); // Logo para sidebar
            $table->string('logo_reportes')->nullable(); // Logo para PDFs/reportes
            $table->string('favicon')->nullable();

            // Configuración de PDFs
            $table->string('pdf_orientacion')->default('portrait'); // portrait, landscape
            $table->string('pdf_tamano')->default('letter'); // letter, legal, a4
            $table->boolean('pdf_mostrar_logo')->default(true);
            $table->boolean('pdf_mostrar_fecha')->default(true);
            $table->boolean('pdf_mostrar_usuario')->default(true);
            $table->text('pdf_footer')->nullable();
            $table->text('pdf_terminos_condiciones')->nullable();

            // Colores y Tema
            $table->string('color_primario')->default('#3b82f6'); // blue-600
            $table->string('color_secundario')->default('#10b981'); // green-500

            // Configuración de Préstamos/Cotizaciones
            $table->decimal('tasa_interes_default', 5, 2)->default(5.00);
            $table->integer('plazo_default')->default(12); // meses
            $table->integer('dias_vencimiento_cotizacion')->default(30);

            // Moneda
            $table->string('moneda')->default('Q'); // Quetzal
            $table->string('moneda_nombre')->default('Quetzales');

            // Notificaciones
            $table->boolean('notificar_stock_bajo')->default(true);
            $table->boolean('notificar_pagos_pendientes')->default(true);
            $table->boolean('notificar_cotizaciones_vencidas')->default(true);

            $table->timestamps();
        });

        // Insertar configuración por defecto
        DB::table('configuraciones')->insert([
            'nombre_aplicacion' => 'CrediHome',
            'slogan' => 'Sistema de Créditos para Materiales de Construcción',
            'pdf_orientacion' => 'portrait',
            'pdf_tamano' => 'letter',
            'color_primario' => '#3b82f6',
            'color_secundario' => '#10b981',
            'tasa_interes_default' => 5.00,
            'plazo_default' => 12,
            'dias_vencimiento_cotizacion' => 30,
            'moneda' => 'Q',
            'moneda_nombre' => 'Quetzales',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
    }
};
