<?php

use Illuminate\Database\Seeder;

class DestinationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::table('destinations')->insert(array(
        'destination' => 'Tienda',
      ));

      \DB::table('destinations')->insert(array(
        'destination' => 'Piso 1',
      ));

      \DB::table('destinations')->insert(array(
        'destination' => 'Piso 2',
      ));

      \DB::table('destinations')->insert(array(
        'destination' => 'Piso 3',
      ));
    }
}
