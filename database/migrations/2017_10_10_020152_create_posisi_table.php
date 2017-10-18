<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_posisi', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_bidang')->unsigned();
          $table->string('kode_posisi');
          $table->string('nama_posisi');
          $table->string('flag_aktif')->default('Y');
          $table->integer('id_aktor')->unsigned();
          $table->timestamps();

          $table->foreign('id_bidang')->references('id')->on('fra_bidang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
