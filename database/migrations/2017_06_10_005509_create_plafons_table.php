<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlafonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bmt_plafon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_plafon');
            $table->string('besar');
            $table->text('deskripsi');
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
        Schema::dropIfExists('plafons');
    }
}
