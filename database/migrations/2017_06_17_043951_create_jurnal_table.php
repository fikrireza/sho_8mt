<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurnalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bmt_jurnal', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_iuran')->unsigned();
          $table->date('tanggal_iuran');
          $table->string('keterangan')->nullable();
          $table->string('jumlah')->nullable();
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
