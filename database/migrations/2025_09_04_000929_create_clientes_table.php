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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('correo')->unique();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('codigo')->unique(); // Número de cliente único
            $table->string('telefono_alt', 25)->nullable();
            $table->string('pais')->default('El Salvador');
            //  Identificación fiscal
            $table->string('nit', 30)->nullable();     // Número de identificación tributaria
            $table->string('dui', 15)->nullable();     // Documento único de identidad
            $table->string('nrc', 20)->nullable();     // Número de registro de contribuyente (empresas)
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->unsignedBigInteger('id_municipio');
            $table->unsignedBigInteger('tipo_cliente_id');
            $table->timestamps();

            // relacion a municipios
            $table->foreign('id_municipio')
                ->references('id')
                ->on('municipios')
                ->onDelete('cascade');

            // relacion al tipo de persona
              $table->foreign('tipo_cliente_id')
                ->references('id')
                ->on('tipo_cliente')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
