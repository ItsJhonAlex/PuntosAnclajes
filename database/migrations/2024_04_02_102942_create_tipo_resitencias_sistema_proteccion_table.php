<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoResitenciasSistemaProteccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_resistencia_sistemas_proteccion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cantidad_resistencia');
            $table->string('unidad_resistencia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('isi_resistencia_sistemas_proteccion');
    }
}
