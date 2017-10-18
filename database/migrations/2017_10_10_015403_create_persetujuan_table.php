<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersetujuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fra_persetujuan', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_akad')->unsigned();
          $table->string('no_persetujuan')->unique();
          $table->date('tangal_persetujuan');
          // Approve = A; Cancel = C;
          $table->string('status_persetujuan', 1);
          $table->text('keterangan')->nullable();
          $table->integer('id_aktor')->unsigned();
          $table->timestamps();

          $table->index(['no_persetujuan', 'id_akad']);
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
