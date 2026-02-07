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
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->integer('plazo_meses')->nullable()->after('total');
            $table->decimal('tasa_interes_anual', 5, 2)->nullable()->after('plazo_meses');
            $table->decimal('enganche', 12, 2)->nullable()->after('tasa_interes_anual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizaciones', function (Blueprint $table) {
            $table->dropColumn(['plazo_meses', 'tasa_interes_anual', 'enganche']);
        });
    }
};
