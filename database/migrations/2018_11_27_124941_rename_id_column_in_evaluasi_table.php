<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIdColumnInEvaluasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_evaluasi', function (Blueprint $table) {
            $table->renameColumn('id','id_evaluasi');
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
            $table->renameColumn('id_evaluasi','id');
            
        });
    }
}
