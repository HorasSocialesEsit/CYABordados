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
            // Relación con la orden principal
            $table->unsignedBigInteger('orden_id');
            $table->foreign('orden_id')->references('id')->on('ordenes')->onDelete('cascade');

            // Monto del pago
            $table->decimal('monto', 12, 2);

            // Tipo de pago (anticipo, abono, saldo final)
            $table->enum('tipo', ['anticipo', 'abono', 'saldoFinal'])->default('anticipo');

            // Método de pago (efectivo)
            $table->string('metodo')->nullable();

            // Fecha y usuario que registró el pago
            $table->timestamp('fecha_pago')->useCurrent();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');

            // Nota opcional
            $table->text('nota')->nullable();
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
