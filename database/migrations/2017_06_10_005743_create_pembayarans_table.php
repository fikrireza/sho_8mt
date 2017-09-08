<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bmt_pembayaran', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_pembayaran');
            $table->date('tanggal_pembayaran');
            $table->text('keterangan');
            $table->string('jenis_pembayaran');
            $table->string('nilai_pembayaran');
            $table->integer('id_persetujuan')->unsigned();
            $table->integer('id_aktor')->unsigned();
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
        Schema::dropIfExists('pembayarans');
    }
}
