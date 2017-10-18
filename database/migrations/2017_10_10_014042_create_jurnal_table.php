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
        Schema::create('fra_jurnal', function(Blueprint $table){
          $table->increments('id');
          $table->integer('id_akad')->unsigned();
          $table->integer('id_iuran')->unsigned()->nullable();
          $table->date('tanggal_jurnal');
          $table->string('keterangan_jurnal')->nullable();
          $table->string('jumlah')->nullable();
          // Kredit = K; Debit = D;
          $table->string('jenis_jurnal', 1);
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
