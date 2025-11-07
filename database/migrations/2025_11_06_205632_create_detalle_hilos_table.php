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
        Schema::create('detalle_hilos', function (Blueprint $table) {
            $table->id();
            // Relación al detalle de la orden
            $table->unsignedBigInteger('orden_detalle_id');
            $table->foreign('orden_detalle_id')
                ->references('id')
                ->on('orden_detalles')
                ->onDelete('cascade');

            // Relación al hilo usado
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')
                ->references('id')
                ->on('materiales')
                ->onDelete('cascade');

            // Cantidad opcional si más adelante la deseas usar
            $table->integer('cantidad')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_hilos');
    }
};
