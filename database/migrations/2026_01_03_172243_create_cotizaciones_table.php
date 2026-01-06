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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cotizacion')->unique();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('receta_id')->nullable()->constrained('recetas')->onDelete('set null');
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento'); // último día del mes en curso
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'vencida', 'convertida'])->default('pendiente');
            $table->foreignId('prestamo_id')->nullable()->constrained('prestamos')->onDelete('set null'); // si se convierte en préstamo
            $table->text('notas')->nullable();
            $table->text('terminos_condiciones')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('aprobada_en')->nullable();
            $table->foreignId('aprobada_por')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
