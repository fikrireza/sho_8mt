<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldIdBmtToAnggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bmt_anggota', function(Blueprint $table){
          $table->integer('id_bmt')->unsigned()->nullable()->after('id_posisi');
          $table->string('jenis_usaha')->nullable()->after('tanggal_lahir');
          $table->string('lokasi_usaha')->nullable('jenis_usaha');
          $table->dropColumn('jenis_identitas');
          $table->dropColumn('pekerjaan');
          $table->dropColumn('status');
          $table->renameColumn('no_identitas', 'no_ktp');
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
