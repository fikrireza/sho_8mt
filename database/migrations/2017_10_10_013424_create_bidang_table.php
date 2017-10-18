<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_bidang', function(Blueprint $table){
          $table->increments('id');
          $table->string('kode_bidang')->unique();
          $table->string('nama_bidang');
          $table->string('deskripsi');
          $table->string('flag_aktif', 1)->default('Y');
          $table->integer('id_aktor')->unsigned();
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
