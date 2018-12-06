<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeUserColumnToTbPimpinanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_pimpinan', function (Blueprint $table) {
            $table->enum('level',['prodi','fakultas','universitas'])->after('kode_pimpinan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_pimpinan', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
}
