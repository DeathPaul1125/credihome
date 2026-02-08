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
        Schema::table('configuraciones', function (Blueprint $table) {
            // Configuración de Recurrente
            $table->boolean('recurrente_habilitado')->default(false)->after('notificar_cotizaciones_vencidas');
            $table->string('recurrente_public_key')->nullable()->after('recurrente_habilitado');
            $table->string('recurrente_secret_key')->nullable()->after('recurrente_public_key');
            $table->boolean('recurrente_modo_prueba')->default(true)->after('recurrente_secret_key');
            $table->string('recurrente_public_key_test')->nullable()->after('recurrente_modo_prueba');
            $table->string('recurrente_secret_key_test')->nullable()->after('recurrente_public_key_test');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->dropColumn([
                'recurrente_habilitado',
                'recurrente_public_key',
                'recurrente_secret_key',
                'recurrente_modo_prueba',
                'recurrente_public_key_test',
                'recurrente_secret_key_test',
            ]);
        });
    }
};
