<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldPlafonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bmt_plafon', function(Blueprint $table){
          $table->dropColumn('no_plafon');
          $table->dropColumn('besar');
          $table->string('jenis_plafon')->after('id');
          $table->string('jumlah_pembiayaan')->after('jenis_plafon');
          $table->integer('bulan')->unsigned()->after('jumlah_pembiayaan');
          $table->string('iuran')->after('bulan');
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
