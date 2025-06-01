<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIsiPuntosAnclajeRecertificacionTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isi_puntos_anclaje_recertificacion', function (Blueprint $table) {
            $table->unsignedBigInteger('id_empresa');
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
            $table->dropColumn('id_empresa');
        });
    }
}
