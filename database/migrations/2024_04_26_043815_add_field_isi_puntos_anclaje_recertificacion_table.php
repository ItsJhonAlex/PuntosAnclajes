<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIsiPuntosAnclajeRecertificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isi_puntos_anclaje_recertificacion', function (Blueprint $table) {
            $table->string('estado', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('isi_puntos_anclaje_recertificacion', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
