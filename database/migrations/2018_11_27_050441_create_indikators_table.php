<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndikatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_indikator_penilaian', function (Blueprint $table) {
            $table->increments('id_indikator');
            $table->string('nm_indikator');
            $table->integer('id_jenis_indikator')->length(10)->unsigned();
            $table->timestamps();
        });

        Schema::table('tb_indikator_penilaian',function($table){
            $table->foreign('id_jenis_indikator')
            ->references('id_jenis_indikator')
            ->on('tb_jenis_indikator')
            ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_indikator_penilaian');
    }
}
