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
            // Relación con la orden principal
            $table->unsignedBigInteger('orden_id');
            $table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');

            // Información del arte / diseño
            $table->string('nombre_arte')->nullable(); // opcional, para identificar el diseño
            $table->string('tamaño_diseño')->nullable(); // ej. "10x12 cm"
            $table->string('color_hilo')->nullable(); // ej. "Rojo, Dorado"
            $table->string('ubicacion_prenda')->nullable(); // ej. "pecho izquierdo", "espalda", etc.
            $table->enum('tamaño_cuello', ['12', '14', '16'])->nullable(); // disponible para camisas

            // Cantidad y precios
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Control adicional
            $table->text('notas')->nullable(); // observaciones específicas del diseño
            $table->timestamps();
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
