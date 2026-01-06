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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recibo')->unique()->comment('Número de recibo del pago');
            $table->foreignId('prestamo_id')->constrained('prestamos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // Información del Pago
            $table->integer('numero_cuota')->comment('Número de cuota que se está pagando');
            $table->decimal('monto_cuota_esperado', 12, 2)->comment('Monto que se esperaba pagar');
            $table->decimal('monto_pagado', 12, 2)->comment('Monto real pagado en Quetzales');
            $table->decimal('mora', 12, 2)->default(0)->comment('Interés moratorio aplicado');

            // Fechas
            $table->date('fecha_vencimiento')->comment('Fecha en que debía pagarse');
            $table->date('fecha_pago')->comment('Fecha real del pago');
            $table->integer('dias_atraso')->default(0);

            // Estado del Pago
            $table->enum('estado', ['puntual', 'atrasado', 'parcial', 'anticipado'])->default('puntual');
            $table->enum('tipo_pago', ['efectivo', 'transferencia', 'cheque', 'deposito'])->default('efectivo');

            // Saldo después del pago
            $table->decimal('saldo_anterior', 12, 2)->comment('Saldo antes del pago');
            $table->decimal('saldo_nuevo', 12, 2)->comment('Saldo después del pago');

            // Metadata
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->constrained()->comment('Usuario que registró el pago');

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('prestamo_id');
            $table->index('fecha_pago');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
