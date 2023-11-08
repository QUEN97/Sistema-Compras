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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estacion_id');
            $table->unsignedBigInteger('categoria_id');
            $table->string('pdf');
            $table->string('status')->default('Solicitado al Supervisor');
            $table->string('tipo_compra', 15);
            $table->string('razon_social')->nullable();
            $table->string('motivo');
            $table->float('total',12,2)->default(0);
            $table->float('iva',12,2)->default(0);
            $table->float('isr',12,2)->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('estacion_id')->references('id')->on('estacions');
            $table->foreign('categoria_id')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
