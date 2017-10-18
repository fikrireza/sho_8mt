<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIuranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_iuran', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_akad')->unsigned();
          $table->string('kode_iuran')->unique();
          $table->date('tanggal_iuran');
          $table->text('keterangan');
          // Cash dan Transfer
          $table->string('jenis_pembayaran');
          $table->string('img_struk')->nullable();
          $table->string('nilai_iuran');
          $table->integer('id_aktor')->unsigned();
          $table->timestamps();

          $table->index(['id_akad', 'kode_iuran']);

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
