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
        Schema::create('archivos_solicituds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->string('nombre_archivo');
            $table->string('mime_type');
            $table->bigInteger('size');
            $table->string('archivo_path', 2048);
            $table->timestamps();
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_solicituds');
    }
};
