<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnFromTbEvaluasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_evaluasi', function (Blueprint $table) {
            $table->dropColumn('nm_fakultas');
            $table->dropColumn('nm_prodi');
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
            $table->string('nm_fakultas',20)->after('id_fakultas');
            $table->string('nm_prodi',20)->after('id_prodi');
        });
    }
}
