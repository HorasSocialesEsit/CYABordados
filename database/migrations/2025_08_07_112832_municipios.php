<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_municipio', 100);
            $table->unsignedBigInteger('id_departamento');
            $table->timestamps();
            
            $table->foreign('id_departamento')
                ->references('id')
                ->on('departamentos')
                ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipios');
    }
};
