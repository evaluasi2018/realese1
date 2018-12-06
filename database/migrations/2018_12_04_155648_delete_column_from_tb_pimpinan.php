<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnFromTbPimpinan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_pimpinan', function (Blueprint $table) {
            $table->dropColumn('kode_pimpinan');
            $table->dropColumn('level');
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
            $table->string('kode_pimpinan')->length(2)->unique();
            $table->enum('level',['prodi','fakultas','universitas'])->after('kode_pimpinan');
            
        });
    }
}
