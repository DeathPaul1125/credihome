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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('dpi', 13)->unique()->comment('Formato: XXXX XXXXX XXXX');
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['masculino', 'femenino', 'otro']);
            $table->enum('estado_civil', ['soltero', 'casado', 'union_libre', 'divorciado', 'viudo']);

            // Contacto
            $table->string('telefono', 20)->comment('Formato: +502 XXXX-XXXX');
            $table->string('telefono_alternativo', 20)->nullable();
            $table->string('email')->nullable();

            // Dirección
            $table->string('departamento');
            $table->string('municipio');
            $table->text('direccion_completa');
            $table->string('zona')->nullable();

            // Información Laboral
            $table->string('profesion')->nullable();
            $table->string('lugar_trabajo')->nullable();
            $table->string('puesto_trabajo')->nullable();
            $table->decimal('ingreso_mensual', 10, 2)->nullable()->comment('En Quetzales');

            // Referencias
            $table->string('referencia_nombre_1')->nullable();
            $table->string('referencia_telefono_1', 20)->nullable();
            $table->string('referencia_parentesco_1')->nullable();

            $table->string('referencia_nombre_2')->nullable();
            $table->string('referencia_telefono_2', 20)->nullable();
            $table->string('referencia_parentesco_2')->nullable();

            // Estado y notas
            $table->enum('estado', ['activo', 'inactivo', 'bloqueado'])->default('activo');
            $table->text('notas')->nullable();

            // Metadata
            $table->foreignId('user_id')->constrained()->comment('Usuario que registró al cliente');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
