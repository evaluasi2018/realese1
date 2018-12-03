<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNmMatkulToTbSaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_saran', function (Blueprint $table) {
            $table->string('nm_matkul',20)->after('id_matkul');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_saran', function (Blueprint $table) {
            $table->dropColumn('nm_matkul');
            
        });
    }
}
