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
        Schema::create('aportaciones', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('aportador_id')->constrained('aportadores')->onDelete('cascade');
            $table->foreignId('prestamo_id')->constrained('prestamos')->onDelete('cascade');

            // Monto aportado
            $table->decimal('monto_aportado', 15, 2);
            $table->decimal('porcentaje_participacion', 5, 2); // % del préstamo total

            // Recuperación
            $table->decimal('monto_recuperado', 15, 2)->default(0); // Capital recuperado
            $table->decimal('intereses_ganados', 15, 2)->default(0); // Intereses recibidos
            $table->decimal('saldo_pendiente', 15, 2); // Falta por recuperar

            // Fechas importantes
            $table->date('fecha_aportacion');
            $table->date('fecha_recuperacion_completa')->nullable();

            // Estado
            $table->enum('estado', ['Activo', 'Recuperado', 'Mora'])->default('Activo');

            // Notas
            $table->text('notas')->nullable();

            $table->timestamps();

            // Índices
            $table->index(['aportador_id', 'estado']);
            $table->index(['prestamo_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aportaciones');
    }
};
