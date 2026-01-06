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
        Schema::create('chat_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('chat_messages')->onDelete('cascade');
            $table->string('file_name')->comment('Nombre original del archivo');
            $table->string('file_path')->comment('Ruta del archivo en storage');
            $table->string('file_type')->comment('Tipo MIME del archivo');
            $table->string('file_extension', 10)->comment('Extensión del archivo');
            $table->unsignedBigInteger('file_size')->comment('Tamaño en bytes');
            $table->string('thumbnail_path')->nullable()->comment('Miniatura para imágenes');
            $table->timestamps();

            $table->index('message_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_attachments');
    }
};
