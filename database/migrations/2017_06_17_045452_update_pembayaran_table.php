<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bmt_pembayaran', function(Blueprint $table){
          $table->renameColumn('no_pembayaran', 'kode_iuran');
          $table->renameColumn('tanggal_pembayaran', 'tanggal_iuran');
          $table->renameColumn('nilai_pembayaran', 'nilai_iuran');
          $table->renameColumn('id_persetujuan', 'id_akad');
          $table->string('img_struk')->nullable()->after('jenis_pembayaran');
        });

        Schema::rename('bmt_pembayaran', 'bmt_iuran');
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
