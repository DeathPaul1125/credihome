<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
            // Modificar el enum de tipo_interes para agregar los nuevos tipos
            // Mantenemos 'simple' y 'compuesto' (cuota_fija) y agregamos 'flat' y 'sobre_saldos'
            DB::statement("ALTER TABLE prestamos MODIFY COLUMN tipo_interes ENUM('simple', 'compuesto', 'cuota_fija', 'flat', 'sobre_saldos') DEFAULT 'cuota_fija'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
            // Revertir al enum original
            DB::statement("ALTER TABLE prestamos MODIFY COLUMN tipo_interes ENUM('simple', 'compuesto') DEFAULT 'simple'");
        });
    }
};
