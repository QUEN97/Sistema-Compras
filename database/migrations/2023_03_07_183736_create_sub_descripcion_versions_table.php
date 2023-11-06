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
        Schema::create('sub_descripcion_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('panel_version_id');
            $table->string('categoria');
            $table->mediumText('descripcion');
            $table->timestamps();

            $table->foreign('panel_version_id')->references('id')->on('panel_version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_descripcion_versions');
    }
};
