<?php

use Illuminate\Database\Seeder;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('fra_roles')
           ->insert(array(
             array('name' => 'Administrator', 'slug' => 'administrator', 'permissions' => ['read-user' => true, 'read-role' => true]),
             array('name' => 'Admin', 'slug' => 'admin', 'permissions' => ['read-user' => true, 'read-role' => true]),
           ));


       DB::table('fra_role_users')
           ->insert(array(
                     array('user_id'=>'1', 'role_id'=>'1'),
                     array('user_id'=>'2', 'role_id'=>'2'),
                 ));

    }
}
