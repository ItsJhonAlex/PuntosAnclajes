<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isi_empresas', function (Blueprint $table) {
            $table->string('sede');
            $table->string('ciudad');
            $table->string('nit');
            $table->string('nombre_contacto_empresa');
            $table->string('telefono_contacto_empresa');
            $table->string('email_contacto_empresa');
            $table->string('nombre_contacto_empresa_2')->nullable();
            $table->string('telefono_contacto_empresa_2')->nullable();
            $table->string('email_contacto_empresa_2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('isi_empresas', function (Blueprint $table) {
            $table->dropColumn('sede');
            $table->dropColumn('ciudad');
            $table->dropColumn('nit');
            $table->dropColumn('nombre_contacto_empresa');
            $table->dropColumn('telefono_contacto_empresa');
            $table->dropColumn('email_contacto_empresa');
            $table->dropColumn('nombre_contacto_empresa_2');
            $table->dropColumn('telefono_contacto_empresa_2');
            $table->dropColumn('email_contacto_empresa_2');
        });
    }
}
