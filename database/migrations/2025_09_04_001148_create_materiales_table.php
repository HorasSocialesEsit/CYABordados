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
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->unique(); // Ej: MAT101
            $table->text('descripcion')->nullable();
            $table->integer('stock');
           $table->unsignedBigInteger('tipo_hilo_id');

            $table->timestamps();

            // relacion a municipios
            $table->foreign('tipo_hilo_id')
                ->references('id')
                ->on('tipos_hilos')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
