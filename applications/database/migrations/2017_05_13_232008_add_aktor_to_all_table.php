<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAktorToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fra_bmt_peserta', function(Blueprint $table){
          $table->integer('aktor')->unsigned()->after('jumlah_iuran');
        });

        Schema::table('fra_bmt_anggota', function(Blueprint $table){
          $table->integer('aktor')->unsigned()->after('jenis_usaha');
        });

        Schema::table('fra_bmt', function(Blueprint $table){
          $table->integer('aktor')->unsigned()->after('nomor_kontak');
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
