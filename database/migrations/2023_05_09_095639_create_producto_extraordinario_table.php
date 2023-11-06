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
        Schema::create('producto_extraordinario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->string('tipo');
            $table->string('producto_extraordinario');
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('cantidad');
            $table->unsignedBigInteger('total')->default(0);
            $table->boolean('flag_trash')->default(0);
            $table->timestamps();

            $table->foreign('solicitud_id')->references('id')->on('solicituds');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_extraordinario');
    }
};
