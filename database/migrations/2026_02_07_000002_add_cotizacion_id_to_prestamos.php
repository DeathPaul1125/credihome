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
        Schema::table('prestamos', function (Blueprint $table) {
            $table->foreignId('cotizacion_id')
                  ->nullable()
                  ->after('cliente_id')
                  ->constrained('cotizaciones')
                  ->onDelete('set null')
                  ->comment('Cotización origen si el préstamo fue generado desde una cotización');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropForeign(['cotizacion_id']);
            $table->dropColumn('cotizacion_id');
        });
    }
};
