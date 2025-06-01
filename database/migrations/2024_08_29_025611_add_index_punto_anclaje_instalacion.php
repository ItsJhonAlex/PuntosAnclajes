<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexPuntoAnclajeInstalacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isi_punto_anclaje_instalacion', function (Blueprint $table) {
            $table->unique('precinto');
        });

        Schema::table('isi_puntos_anclaje_recertificacion', function (Blueprint $table) {
            $table->unique('precinto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('isi_punto_anclaje_instalacion', function (Blueprint $table) {
            $table->dropUnique(['precinto']);
        });

        Schema::table('isi_puntos_anclaje_recertificacion', function (Blueprint $table) {
            $table->dropUnique(['precinto']);
        });
    }
}
