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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_prestamo')->unique()->comment('Número de identificación del préstamo');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // Información del Préstamo
            $table->decimal('monto_prestado', 12, 2)->comment('Capital inicial en Quetzales');
            $table->decimal('tasa_interes', 5, 2)->comment('Tasa de interés (porcentaje)');
            $table->enum('tipo_interes', ['simple', 'compuesto'])->default('simple');
            $table->integer('plazo')->comment('Número de cuotas');
            $table->enum('frecuencia_pago', ['semanal', 'quincenal', 'mensual'])->default('mensual');

            // Cálculos
            $table->decimal('interes_total', 12, 2)->comment('Interés total a pagar');
            $table->decimal('monto_total', 12, 2)->comment('Capital + Interés');
            $table->decimal('monto_cuota', 12, 2)->comment('Monto de cada cuota');

            // Fechas
            $table->date('fecha_desembolso');
            $table->date('fecha_primer_pago');
            $table->date('fecha_ultimo_pago')->nullable()->comment('Fecha estimada del último pago');

            // Garantía
            $table->enum('tipo_garantia', ['ninguna', 'prenda', 'hipoteca', 'fiador', 'otro'])->default('ninguna');
            $table->text('descripcion_garantia')->nullable();

            // Estado y Seguimiento
            $table->enum('estado', ['pendiente', 'activo', 'pagado', 'vencido', 'en_mora', 'cancelado'])->default('pendiente');
            $table->decimal('saldo_pendiente', 12, 2)->default(0)->comment('Saldo que falta por pagar');
            $table->decimal('total_pagado', 12, 2)->default(0)->comment('Total pagado hasta el momento');
            $table->integer('cuotas_pagadas')->default(0);
            $table->integer('cuotas_vencidas')->default(0);

            // Metadata
            $table->text('notas')->nullable();
            $table->foreignId('user_id')->constrained()->comment('Usuario que creó el préstamo');
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->comment('Usuario que aprobó');
            $table->timestamp('fecha_aprobacion')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índices para búsquedas rápidas
            $table->index('estado');
            $table->index('fecha_desembolso');
            $table->index('cliente_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
