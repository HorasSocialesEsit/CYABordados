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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');

            $table->date('fecha_orden');
            $table->string('codigo_orden')->unique();
            $table->date('fecha_entrega')->nullable();
            $table->enum('estado', ['nueva', 'en_arte', 'arte_aprobado', 'asignada_maquina', 'en_proceso_maquina', 'completada', 'entregada_cliente', 'cancelada'])->default('nueva');
            $table->enum('tipo', ['venta'])->default('venta');

            // Totales de la orden
            $table->decimal('PrecioTotal', 12, 2)->default(0);

            // Control y trazabilidad
            $table->unsignedBigInteger('usuario_id')->nullable(); // quién registró la orden
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
