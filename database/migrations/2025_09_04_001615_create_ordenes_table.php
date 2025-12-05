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
            
            $table->date('fecha_orden');
            $table->string('codigo_orden')->unique();
            $table->date('fecha_entrega')->nullable();
            $table->enum('tipo', ['venta'])->default('venta');
            
            // Totales de la orden
            $table->decimal('precio_total', 12, 2)->default(0);
            $table->datetime('fecha_hora_inicio')->nullable();
            $table->datetime('fecha_hora_fin')->nullable();
            
            $table->unsignedBigInteger('estado_orden_id')->default(1);
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable(); // quién registró la orden

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('estado_orden_id')->references('id')->on('estado_orden')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');

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
