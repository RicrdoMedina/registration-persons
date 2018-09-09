<?php

use Illuminate\Database\Seeder;

class EnterprisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::table('enterprises')->insert(array(
        'enterprise' => 'vawmy c.a',
      ));

      \DB::table('enterprises')->insert(array(
        'enterprise' => 'umpme c.a',
      ));

      \DB::table('enterprises')->insert(array(
        'enterprise' => 'rumpunt c.a',
      ));

      \DB::table('enterprises')->insert(array(
        'enterprise' => 'spumant c.a',
      ));

      \DB::table('enterprises')->insert(array(
        'enterprise' => 'Otra empresa',
      ));
    }
}
