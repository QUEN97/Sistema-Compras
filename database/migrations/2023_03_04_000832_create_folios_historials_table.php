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
        Schema::create('folios_historials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estacion_producto_id');
            $table->unsignedBigInteger('estacion_destino_id')->nullable();
            $table->unsignedBigInteger('folio_id');
            $table->unsignedBigInteger('cantidad');
            $table->mediumText('observacion');
            $table->string('status')->default('Solicitado');
            $table->timestamps();

            $table->foreign('estacion_producto_id')->references('id')->on('estacion_producto')->onDelete('cascade');
            $table->foreign('estacion_destino_id')->references('id')->on('estacions')->onDelete('cascade');
            $table->foreign('folio_id')->references('id')->on('folios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folios_historial');
    }
};
