<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bmt_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 50);
            $table->string('avatar', 255)->default('user.png');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role_id')->unsigned();
            $table->integer('id_anggota')->unsigned()->nullable();
            $table->integer('confirmed')->unsigned()->default(0);
            $table->string('confirmation_code')->nullable();
            $table->integer('login_count')->unsigned()->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
