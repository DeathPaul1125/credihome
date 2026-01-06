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
        Schema::create('distribucion_pagos', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('pago_id')->constrained('pagos')->onDelete('cascade');
            $table->foreignId('aportacion_id')->constrained('aportaciones')->onDelete('cascade');
            $table->foreignId('aportador_id')->constrained('aportadores')->onDelete('cascade');

            // Montos distribuidos
            $table->decimal('monto_capital', 15, 2); // Parte del capital
            $table->decimal('monto_interes', 15, 2); // Parte de intereses
            $table->decimal('monto_total', 15, 2); // Total distribuido

            // Porcentaje aplicado
            $table->decimal('porcentaje_aplicado', 5, 2);

            // Fecha de distribución
            $table->timestamp('fecha_distribucion');

            $table->timestamps();

            // Índices
            $table->index(['pago_id', 'aportador_id']);
            $table->index('aportacion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribucion_pagos');
    }
};
