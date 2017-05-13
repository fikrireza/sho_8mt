<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBmtAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_bmt_anggota', function(Blueprint $table){
          $table->increments('id');
          $table->string('bmt_id');
          $table->string('no_ktp')->unique();
          $table->string('nama');
          $table->text('alamat');
          $table->string('tempat_lahir');
          $table->date('tanggal_lahir');
          $table->text('lokasi_usaha');
          $table->string('jenis_usaha');
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
