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
        Schema::create('aportadores', function (Blueprint $table) {
            $table->id();

            // Información personal
            $table->string('nombre');
            $table->string('dpi', 13)->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('telefono')->nullable();
            $table->text('direccion')->nullable();

            // Tipo de aportador
            $table->enum('tipo', ['Persona', 'Empresa', 'Institución'])->default('Persona');
            $table->string('empresa')->nullable(); // Si es empresa
            $table->string('nit')->nullable();

            // Información financiera
            $table->decimal('capital_disponible', 15, 2)->default(0); // Dinero disponible para prestar
            $table->decimal('capital_invertido', 15, 2)->default(0); // Total actualmente en préstamos
            $table->decimal('capital_recuperado', 15, 2)->default(0); // Total recuperado de préstamos
            $table->decimal('ganancias_totales', 15, 2)->default(0); // Total de intereses ganados

            // Configuración
            $table->decimal('tasa_interes_minima', 5, 2)->nullable(); // % mínimo que acepta
            $table->integer('plazo_maximo')->nullable(); // Meses máximo que financia
            $table->decimal('monto_minimo_prestamo', 15, 2)->nullable(); // Monto mínimo por préstamo
            $table->decimal('monto_maximo_prestamo', 15, 2)->nullable(); // Monto máximo por préstamo

            // Estado y notas
            $table->enum('estado', ['Activo', 'Inactivo', 'Suspendido'])->default('Activo');
            $table->text('notas')->nullable();

            // Usuario que registró
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aportadores');
    }
};
