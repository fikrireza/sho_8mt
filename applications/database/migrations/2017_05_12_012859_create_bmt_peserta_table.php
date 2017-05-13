<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBmtPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_bmt_peserta', function(Blueprint $table){
          $table->increments('id');
          $table->string('bmt_id');
          $table->date('tanggal_join');
          $table->string('no_ktp');
          $table->string('nama');
          $table->text('alamat');
          $table->string('tempat_lahir');
          $table->date('tanggal_lahir');
          $table->text('lokasi_usaha');
          $table->string('jenis_usaha');
          $table->string('rekening');
          $table->string('jumlah_pembiayaan');
          $table->date('tanggal_akad');
          $table->date('jatuh_tempo');
          $table->integer('jangka_waktu');
          $table->string('iuran_jiwa');
          $table->string('iuran_kebakaran');
          $table->string('jumlah_iuran');
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
