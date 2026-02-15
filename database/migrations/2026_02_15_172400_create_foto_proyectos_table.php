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
        Schema::create('foto_proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('prestamo_id')->nullable()->constrained('prestamos')->onDelete('set null');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('ruta_imagen');
            $table->date('fecha_avance');
            $table->decimal('porcentaje_avance', 5, 2)->nullable()->comment('Porcentaje de avance del proyecto');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->text('comentario_admin')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['cliente_id', 'fecha_avance']);
            $table->index(['prestamo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_proyectos');
    }
};
