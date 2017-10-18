<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKlaimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_klaim', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_akad')->unsigned();
          $table->string('no_permohonan')->unique();
          $table->date('tanggal_musibah');
          $table->text('keterangan_musibah');
          $table->string('sisa_bayar');
          $table->string('total_bayar');
          $table->integer('flag_status')->unsigned()->default(1);
          $table->integer('id_aktor')->unsigned();
          $table->timestamps();

          $table->index(['no_permohonan', 'id_akad']);
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
