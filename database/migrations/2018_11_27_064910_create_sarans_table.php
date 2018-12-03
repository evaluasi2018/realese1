<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_saran', function (Blueprint $table) {
            $table->increments('id_saran',9);
            $table->string('npm')->length(9);
            $table->string('nip')->length(18);
            $table->string('nm_dosen')->length(30);
            $table->string('id_matkul')->length(8);
            $table->string('id_kelas')->length(15);
            $table->integer('semester')->length(5)->unsigned();
            $table->string('saran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_saran');
    }
}
