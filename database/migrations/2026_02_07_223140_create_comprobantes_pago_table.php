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
        Schema::create('comprobantes_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('numero_comprobante')->unique();
            $table->decimal('monto_pagado', 10, 2);
            $table->date('fecha_pago');
            $table->string('archivo_comprobante'); // ruta del archivo
            $table->enum('metodo_pago', ['efectivo', 'transferencia', 'deposito', 'cheque', 'otro'])->default('transferencia');
            $table->string('numero_referencia')->nullable(); // número de transferencia/cheque
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->foreignId('validado_por')->nullable()->constrained('users')->comment('Usuario que validó');
            $table->timestamp('fecha_validacion')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->foreignId('pago_id')->nullable()->constrained('pagos')->comment('Pago generado al aprobar');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes_pago');
    }
};
