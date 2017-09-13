<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateKlaimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bmt_klaim', function(Blueprint $table){
          $table->integer('id_akad')->unsigned()->after('id_anggota');
          $table->renameColumn('tanggal_permohonan', 'tanggal_musibah');
          $table->renameColumn('alasan_permohonan', 'keterangan_musibah');
          $table->dropColumn('keterangan');
          $table->string('sisa_bayar')->after('keterangan');
          $table->string('total_bayar')->after('sisa_bayar');
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
