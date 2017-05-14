<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fra_bmt_anggota', function(Blueprint $table){
          $table->string('email')->nullable()->after('jenis_usaha');
        });

        Schema::table('fra_bmt', function(Blueprint $table){
          $table->string('email')->nullable()->after('nomor_kontak');
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
