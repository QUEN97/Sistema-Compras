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
        Schema::create('archivos_facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_factura');
            $table->string('nombre_archivo');
            $table->string('mime_type');
            $table->bigInteger('size');
            $table->string('archivo_path', 2048);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_factura')->references('id')->on('facturas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivos_facturas');
    }
};
