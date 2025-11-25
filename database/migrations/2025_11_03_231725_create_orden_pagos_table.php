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
        Schema::create('orden_pagos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 12, 2);  // Monto del pago
            $table->string('metodo')->nullable(); // Método de pago (efectivo)
            $table->timestamp('fecha_pago')->useCurrent();    // Fecha y usuario que registró el pago
            $table->text('nota')->nullable();
            $table->decimal('saldo_restante', 12, 2);  // Monto del pago

            $table->unsignedBigInteger('orden_id');
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('tipo_pago_id')->default(1);

            // Nota opcional
            $table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('tipo_pago_id')->references('id')->on('tipo_pago')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_pagos');
    }
};
