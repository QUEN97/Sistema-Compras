<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estacion_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estacion_id')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('stock');
            $table->unsignedBigInteger('stock_fijo')->nullable();
            $table->string('status');
            $table->boolean('flag_trash')->default(0);
            $table->timestamps();

            $table->foreign('estacion_id')->references('id')->on('estacions');
            $table->foreign('supervisor_id')->references('supervisor_id')->on('estacions');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estacion_productos');
    }
};
