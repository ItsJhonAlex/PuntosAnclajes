<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsiPuntoAnclajeInstalacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isi_puntos_anclaje', function (Blueprint $table) {
            $table->string('propuesta_instalacion');
            
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
            $table->dropColumn('propuesta_instalacion');
        });
    }
}
