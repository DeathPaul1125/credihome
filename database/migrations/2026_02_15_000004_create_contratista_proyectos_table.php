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
        Schema::create('contratista_proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contratista_id')->constrained('contratistas')->onDelete('cascade');
            $table->string('nombre_proyecto');
            $table->text('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('cliente')->nullable()->comment('Nombre del cliente del proyecto');
            $table->enum('tipo_proyecto', ['construccion_nueva', 'remodelacion', 'ampliacion', 'otro'])->default('construccion_nueva');
            $table->decimal('monto_proyecto', 15, 2)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->enum('estado', ['planificacion', 'en_proceso', 'completado', 'cancelado'])->default('planificacion');
            $table->integer('duracion_dias')->nullable();
            $table->text('materiales_utilizados')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratista_proyectos');
    }
};
