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
        // Modificar el enum para incluir 'pendiente_fondeo'
        DB::statement("ALTER TABLE prestamos MODIFY COLUMN estado ENUM('pendiente', 'pendiente_fondeo', 'activo', 'pagado', 'vencido', 'en_mora', 'cancelado') DEFAULT 'pendiente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir al enum original
        DB::statement("ALTER TABLE prestamos MODIFY COLUMN estado ENUM('pendiente', 'activo', 'pagado', 'vencido', 'en_mora', 'cancelado') DEFAULT 'pendiente'");
    }
};
