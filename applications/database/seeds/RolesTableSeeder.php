<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('fra_roles')->insert(array(
        array('title'=>'PBMT', 'slug'=>'pbmt'),
        array('title'=>'BMT', 'slug'=>'bmt')
      ));


    }
}
