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
        Schema::create('contratista_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contratista_id')->constrained('contratistas')->onDelete('cascade');
            $table->string('nombre_archivo');
            $table->enum('tipo_documento', [
                'dpi',
                'cedula_comercio',
                'patente_comercio',
                'certificacion_laboral',
                'certificacion_tecnica',
                'titulo_profesional',
                'referencias',
                'contrato',
                'foto_proyecto',
                'otro'
            ])->default('otro');
            $table->string('ruta_archivo');
            $table->string('mime_type')->nullable();
            $table->integer('tamano_kb')->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fecha_vigencia')->nullable()->comment('Para documentos con vencimiento');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratista_archivos');
    }
};
