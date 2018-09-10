<?php

use Illuminate\Database\Seeder;

class MotiveVisitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::table('motive_visits')->insert(array(
        'motive_visit' => 'Entrevista RRHH',
      ));

      \DB::table('motive_visits')->insert(array(
        'motive_visit' => 'Entrega Curriculum Vitae RRHH',
      ));

      \DB::table('motive_visits')->insert(array(
        'motive_visit' => 'Compra de telas en tienda',
      ));

      \DB::table('motive_visits')->insert(array(
        'motive_visit' => 'Reunión',
      ));

      \DB::table('motive_visits')->insert(array(
        'motive_visit' => 'Otro motivo',
      ));
    }
}
