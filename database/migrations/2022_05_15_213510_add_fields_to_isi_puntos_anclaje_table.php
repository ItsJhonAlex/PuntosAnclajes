<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToIsiPuntosAnclajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isi_puntos_anclaje', function (Blueprint $table) {
            $table->dateTime('fecha_proxima_inspeccion');
            $table->string('instalador', 100);
            $table->string('resistencia', 100);
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('isi_puntos_anclaje', function (Blueprint $table) {
            //
        });
    }
}
