<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAkadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bmt_akad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_plafon')->unsigned();
            $table->integer('id_anggota')->unsigned();
            $table->string('no_akad');
            $table->string('nama_akad');
            $table->date('tanggal_akad');
            $table->text('keterangan');
            $table->string('jenis_pembayaran');
            $table->string('lama_pembayaran');
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
        Schema::dropIfExists('akads');
    }
}
