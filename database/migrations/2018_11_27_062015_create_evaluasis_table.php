<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_evaluasi', function (Blueprint $table) {
            $table->increments('id',9);
            $table->string('npm')->length(9);
            $table->string('nip')->length(18);
            $table->string('nm_dosen')->length(30);
            $table->string('id_matkul')->length(8);
            $table->string('id_kelas')->length(15);
            $table->integer('semester')->length(5)->unsigned();
            $table->integer('id_indikator')->length(10)->unsigned();
            $table->smallInteger('nilai')->length(2)->unsigned();
            $table->timestamps();
        });

        Schema::table('tb_evaluasi',function($table){
            $table->foreign('id_indikator')
            ->references('id_indikator')
            ->on('tb_indikator_penilaian')
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
        Schema::dropIfExists('tb_evaluasi');
    }
}
