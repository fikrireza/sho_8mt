<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_anggota', function(Blueprint $table){
          $table->increments('id');
          $table->string('kode_anggota', 50)->unique();
          $table->integer('id_posisi')->unsigned()->nullable();
          $table->integer('id_bmt')->unsigned()->nullable();
          $table->string('nama_anggota');
          $table->string('jenis_kelamin');
          $table->text('alamat');
          $table->string('kode_pos')->nullable();
          $table->string('no_telp');
          $table->string('tempat_lahir');
          $table->date('tanggal_lahir');
          $table->string('jenis_usaha')->nullable();
          $table->string('lokasi_usaha')->nullable();
          $table->string('no_ktp');
          $table->string('status_pernikahan', 1);
          $table->string('foto')->nullable();
          $table->string('email')->nullable();
          $table->string('flag_aktif', 1)->default('Y');
          $table->integer('id_aktor')->unsigned();
          $table->timestamps();

          $table->index(['kode_anggota','nama_anggota']);
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
