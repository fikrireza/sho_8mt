<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlafonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_plafon', function (Blueprint $table) {
          $table->increments('id');
          // Jiwa; Musibah;
          $table->string('jenis_plafon');
          $table->string('jumlah_pembiayaan');
          $table->string('bulan');
          $table->string('iuran');
          $table->text('deskripsi');
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
