<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAkadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_akad', function (Blueprint $table) {
          $table->increments('id');
          $table->string('kode_akad')->unique();
          $table->integer('id_plafon')->unsigned();
          $table->integer('id_anggota')->unsigned();
          $table->date('tanggal_akad');
          $table->text('keterangan');
          // Cash dan Transfer
          $table->string('jenis_pembayaran');
          $table->integer('approved_by')->unsigned()->nullable();
          $table->date('approved_date')->nullable();
          $table->date('tanggal_lunas')->nullable();
          // Belum Approve = BA; Approve = A; Cancel = C; Lunas = L;
          $table->string('flag_status', 3)->default('BA');
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
