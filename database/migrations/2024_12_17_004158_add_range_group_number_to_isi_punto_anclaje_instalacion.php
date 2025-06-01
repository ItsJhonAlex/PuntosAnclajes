<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRangeGroupNumberToIsiPuntoAnclajeInstalacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isi_punto_anclaje_instalacion', function (Blueprint $table) {
            $table->integer('range_group_number')->default(0);
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
            $table->dropColumn('range_group_number');
        });
    }
}
