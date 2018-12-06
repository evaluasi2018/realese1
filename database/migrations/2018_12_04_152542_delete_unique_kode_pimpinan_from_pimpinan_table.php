<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteUniqueKodePimpinanFromPimpinanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_pimpinan', function (Blueprint $table) {
            $table->dropUnique(['kode_pimpinan']);
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
            $table->unique('kode_pimpinan');
        });
    }
}
