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
          $table->string('no_induk')->unique();
          $table->string('nama');
          $table->text('alamat');
          $table->string('mpd');
          $table->string('mpw');
          $table->string('telp');
          $table->string('nama_kontak');
          $table->string('nomor_kontak');
          $table->integer('flag_status')->unsigned()->default(1);
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
