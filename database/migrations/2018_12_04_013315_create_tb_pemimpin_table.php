<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPemimpinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pimpinan', function (Blueprint $table) {
            $table->increments('id_pimpinan');
            $table->string('nm_pimpinan')->string(30);
            $table->string('username')->length(30)->unique();
            $table->string('kode_pimpinan')->length(2)->unique();
            $table->string('password')->length(72);
            
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
        Schema::dropIfExists('tb_pimpinan');
    }
}
