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
        Schema::create('historial_orden', function (Blueprint $table) {
            $table->id();
            $table->string('rpm');
            $table->integer('puntadas');
            $table->integer('secuencias');
            $table->integer('cabezales');
            $table->integer('tiempo_cambio');
            $table->decimal('eficiencia');
            $table->integer('ciclos');
            $table->decimal('horas');
            $table->integer('minutos');
            $table->integer('cantidad');
            $table->integer('realizada');
            $table->integer('restante');
            $table->unsignedBigInteger('orden_id');
            $table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_orden');
    }
};
