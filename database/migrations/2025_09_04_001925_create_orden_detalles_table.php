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
        Schema::create('orden_detalles', function (Blueprint $table) {
            $table->id();

            // Información del arte / diseño
            $table->string('nombre_arte')->nullable(); // opcional, para identificar el diseño
            $table->string('tamano_diseno')->nullable(); // ej. "10x12 cm"
            //  $table->string('color_hilo')->nullable(); // ej. "Rojo, Dorado"
            $table->string('ubicacion_prenda')->nullable(); // ej. "pecho izquierdo", "espalda", etc.
            $table->enum('tamano_cuello', ['12', '14', '16'])->nullable(); // disponible para camisas

            // Cantidad y precios
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Control adicional
            $table->text('notas')->nullable(); // observaciones específicas del diseño
            $table->unsignedBigInteger('orden_id');
            $table->unsignedBigInteger('maquina_id')->nullable();
            $table->timestamps();
            // Relación con la orden principal
            $table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');
            //   $table->foreign('maquina_id')->references('id')->on('maquinas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_detalles');
    }
};
