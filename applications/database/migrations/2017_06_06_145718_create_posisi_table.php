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
        Schema::create('bmt_posisi', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_bidang')->unsigned();
          $table->string('kode_posisi');
          $table->string('nama_posisi');
          $table->integer('id_aktor')->unsigned();
          $table->integer('flag_status')->unsigned();
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
        //
    }
}
