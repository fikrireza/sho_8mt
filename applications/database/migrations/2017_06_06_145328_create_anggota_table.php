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
        Schema::create('bmt_anggota', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_anggota', 50);
            // 1 = Anggota BMT; 2 = Peserta BMT
            $table->integer('status')->default(1);
            $table->integer('id_posisi')->unsigned()->nullable();
            $table->string('nama_anggota');
            $table->string('jenis_kelamin');
            $table->text('alamat');
            $table->string('kode_pos');
            $table->string('no_telp');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_identitas');
            $table->string('no_identitas');
            $table->integer('status_pernihakan')->unsigned();
            $table->string('pekerjaan');
            $table->string('foto')->nullable();
            $table->string('email')->nullable();
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
        //
    }
}
