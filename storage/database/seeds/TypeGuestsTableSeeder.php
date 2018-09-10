<?php

use Illuminate\Database\Seeder;

class TypeGuestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::table('type_guests')->insert(array(
        'type_guest' => 'Cliente',
      ));

      \DB::table('type_guests')->insert(array(
        'type_guest' => 'Visitante',
      ));
    }
}
