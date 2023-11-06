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
        Schema::create('panel_permiso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permiso_id');
            $table->unsignedBigInteger('panel_id');
            $table->boolean('wr')->default(0);
            $table->boolean('re')->default(0);
            $table->boolean('ed')->default(0);
            $table->boolean('de')->default(0);
            $table->boolean('vermas')->default(0);
            $table->boolean('verpap')->default(0);
            $table->boolean('restpap')->default(0);
            $table->boolean('vermaspap')->default(0);
            $table->timestamps();

            $table->foreign('permiso_id')->references('id')->on('permisos');
            $table->foreign('panel_id')->references('id')->on('panels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panel_permiso');
    }
};
