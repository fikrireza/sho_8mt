<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersetujuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bmt_persetujuan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_persetujuan');
            $table->date('tangal_persetujuan');
            $table->text('keterangan');
            $table->integer('id_akad')->unsigned();
            $table->integer('status_akad')->unsigned();
            $table->integer('id_anggota')->unsigned();
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
        Schema::dropIfExists('persetujuans');
    }
}