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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_contrato')->unique();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('prestamo_id')->constrained('prestamos')->onDelete('cascade');
            $table->foreignId('contratista_id')->constrained('contratistas')->onDelete('cascade');
            $table->string('titulo');
            $table->longText('contenido'); // HTML del editor de texto enriquecido
            $table->enum('estado', ['borrador', 'activo', 'finalizado', 'cancelado'])->default('borrador');
            $table->date('fecha_contrato');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->decimal('monto_contrato', 15, 2)->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('creado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['cliente_id', 'estado']);
            $table->index(['contratista_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
