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
    //   'nueva', 'en_diseño', 'asignada_maquina', 'en_proceso_maquina', 'completada', 'entregada_cliente', 'cancelada'
        Schema::create('estado_orden', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_estado_orden')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_orden');
    }
};
