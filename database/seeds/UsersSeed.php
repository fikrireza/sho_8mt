<?php

use Illuminate\Database\Seeder;

class UsersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('fra_users')
          ->insert(array(
                  array('name'=>'Administrator', 'email'=>'administrator@gmail.com', 'password'=>bcrypt('12345678'), 'avatar'=> '', 'confirmation_code' => '', 'confirmed'=>1, 'login_count'=>1),
                  array('name'=>'Admin', 'email'=>'admin@gmail.com', 'password'=>bcrypt('12345678'), 'avatar'=> '', 'confirmation_code' => '', 'confirmed'=>1, 'login_count'=>1),
                ));
    }
}
