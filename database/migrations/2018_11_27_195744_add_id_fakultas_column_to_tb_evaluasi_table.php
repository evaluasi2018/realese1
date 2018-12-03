<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdFakultasColumnToTbEvaluasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_evaluasi', function (Blueprint $table) {
            $table->string('id_fakultas',1)->after('nm_prodi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_evaluasi', function (Blueprint $table) {
            $table->dropColumn('id_fakultas');
        });
    }
}
