<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAkadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bmt_akad', function(Blueprint $table){
          $table->dropColumn('nama_akad');
          $table->dropColumn('lama_pembayaran');
          $table->renameColumn('no_akad', 'kode_akad')
          $table->integer('approved_by')->unsigned()->nullable()->after('flag_status');
          $table->date('approved_date')->nullable()->after('approved_by');
          $table->boolean('flag_lunas')->default(0)->after('approved_date');
          $table->date('tanggal_lunas')->nullable()->after('flag_lunas');
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
