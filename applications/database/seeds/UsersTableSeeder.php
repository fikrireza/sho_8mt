<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('fra_users')->insert(array(
        array('nama'=>'PBMT', 'email'=>'pbmt@gmail.com', 'password'=>bcrypt('12345678'), 'role_id'=> 1, 'confirmed'=>1, 'login_count'=>1),
        array('nama'=>'BMT', 'email'=>'bmt@gmail.com', 'password'=>bcrypt('12345678'), 'role_id'=> 2, 'confirmed'=>1, 'login_count'=>1),
      ));

    }
}
