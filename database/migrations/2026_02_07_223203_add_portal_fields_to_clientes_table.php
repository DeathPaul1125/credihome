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
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreignId('portal_user_id')->nullable()->after('user_id')->constrained('users')->comment('Usuario para acceder al portal del cliente');
            $table->boolean('portal_activo')->default(false)->after('portal_user_id')->comment('Si el cliente tiene acceso al portal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['portal_user_id']);
            $table->dropColumn(['portal_user_id', 'portal_activo']);
        });
    }
};
