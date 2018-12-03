<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTbSaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_saran', function (Blueprint $table) {
            $table->string('id_prodi',4)->after('semester');
            $table->string('nm_prodi',20)->after('id_prodi');
            $table->string('id_fakultas',1)->after('nm_prodi');
            $table->string('nm_fakultas',20)->after('id_fakultas');
            
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
            $table->dropColumn('id_prodi');
            $table->dropColumn('nm_prodi');
            $table->dropColumn('id_fakultas');
            $table->dropColumn('nm_fakultas');
            
        });
    }
}
