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
        Schema::create('archivos_fo_histos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folios_historial_id');
            $table->string('nombre_remision');
            $table->string('mime_type_remision');
            $table->bigInteger('size_remision');
            $table->string('path_remision', 2048);
            $table->string('nombre_condiciones')->nullable();
            $table->string('mime_type_condiciones')->nullable();
            $table->bigInteger('size_condiciones')->nullable();
            $table->string('path_condiciones', 2048)->nullable();
            $table->boolean('flag_trash')->default(0);
            $table->timestamps();

            $table->foreign('folios_historial_id')->references('id')->on('folios_historials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_fo_histos');
    }
};
