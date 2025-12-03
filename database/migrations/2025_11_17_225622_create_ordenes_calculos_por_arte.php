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
        Schema::create('ordenes_calculos_por_arte', function (Blueprint $table) {
            $table->id();
            // Campos específicos para los cálculos por arte
            $table->integer('puntadas');
            $table->integer('secuencias');
            $table->integer('rpm');
            $table->decimal('tiempo_ciclo', 10, 2);
            $table->string('nota_adicional', 255)->nullable();
            $table->string('ruta_arte', 255)->nullable();
            $table->decimal('tiempo_total_orden', 10, 2)->default(0);
            $table->integer('ciclos');
            $table->integer('cabezales')->default(1);

            // id maquina
            $table->unsignedBigInteger('maquina_id');
            $table->foreign('maquina_id')->references('id')->on('maquinas')->onDelete('cascade');

            // Relación con la orden principal
            $table->unsignedBigInteger('orden_id_calculo');
            $table->foreign('orden_id_calculo')->references('id')->on('ordenes')->onDelete('cascade');
            // Relación con el arte asociado
            $table->unsignedBigInteger('arte_id');
            $table->foreign('arte_id')->references('id')->on('orden_detalles')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_calculos_por_arte');
    }
};
