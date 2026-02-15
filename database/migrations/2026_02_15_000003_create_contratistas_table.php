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
        Schema::create('contratistas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->comment('Código único del contratista');
            $table->string('nombre_completo');
            $table->string('nombre_empresa')->nullable();
            $table->string('dpi', 20)->nullable();
            $table->string('nit', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->string('municipio')->nullable();
            $table->string('departamento')->nullable();
            $table->string('telefono1', 20);
            $table->string('telefono2', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('especialidad')->nullable()->comment('Especialidad o área de construcción');
            $table->enum('tipo_servicio', ['construccion', 'remodelacion', 'ambos'])->default('ambos');
            $table->text('servicios_ofrecidos')->nullable()->comment('Detalle de servicios que ofrece');
            $table->integer('anos_experiencia')->nullable();
            $table->decimal('calificacion', 3, 2)->nullable()->default(0)->comment('Calificación promedio 0-5');
            $table->text('notas')->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'suspendido'])->default('activo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratistas');
    }
};
