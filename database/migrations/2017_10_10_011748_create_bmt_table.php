<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBmtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_bmt', function(Blueprint $table){
          $table->increments('id');
          $table->string('no_induk_bmt')->unique();
          $table->string('nama_bmt');
          $table->text('alamat_bmt');
          $table->string('mpd_bmt');
          $table->string('mpw_bmt');
          $table->string('telp_bmt');
          $table->string('nama_kontak_bmt');
          $table->string('nomor_kontak_bmt');
          $table->string('email_bmt')->nullable();
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
