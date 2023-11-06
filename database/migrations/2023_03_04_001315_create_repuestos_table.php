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
        Schema::create('repuestos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estacion_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('cantidad');
            $table->mediumText('descripcion');
            $table->string('status')->default('Solicitado al Supervisor');
            $table->boolean('flag_trash')->default(0);
            $table->timestamps();

            $table->foreign('estacion_id')->references('id')->on('estacions')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repuestos');
    }
};
