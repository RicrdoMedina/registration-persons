<?php

use Illuminate\Database\Seeder;

class TypeVisitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::table('type_visits')->insert(array(
        'type_visit' => 'Formal',
      ));

      \DB::table('type_visits')->insert(array(
        'type_visit' => 'Particular',
      ));
    }
}
