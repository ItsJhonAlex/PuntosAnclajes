<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsiPuntoAnclajeRecertificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_puntos_anclaje_recertificacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('propuesta_principal');
            $table->string('propuesta_recertificacion');
            $table->smallInteger('sistema_proteccion');
            $table->string('serial', 100);
            $table->string('precinto', 100);
            $table->dateTime('fecha_recertificacion');
            $table->string('marca', 100);
            $table->smallInteger('numero_usuarios');
            $table->string('uso', 100);
            $table->string('observaciones', 100);
            $table->string('ubicacion', 100);
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
        Schema::dropIfExists('isi_puntos_anclaje_recertificacion');
    }
}
