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
        Schema::create('manual_permiso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manual_id');
            $table->unsignedBigInteger('permiso_id');
            $table->boolean('flag_trash')->default(0);
            $table->timestamps();

            $table->foreign('manual_id')->references('id')->on('manuals')->onDelete('cascade');
            $table->foreign('permiso_id')->references('id')->on('permisos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_permisos');
    }
};
