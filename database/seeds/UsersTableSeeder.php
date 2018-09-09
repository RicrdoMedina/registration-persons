<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(array(
            'email' => 'user@gmail.com',
            'nombre' => 'Tommy',
            'apellido' => 'Turner',
            'password' => \Hash::make('1234'),
            'status' => '1',
            'rol' => '2',
         ));

         \DB::table('users')->insert(array(
          'email' => 'admin@gmail.com',
          'nombre' => 'Ricardo',
          'apellido' => 'Medina',
          'password' => \Hash::make('1234'),
          'status' => '1',
          'rol' => '1',
       ));
    }
}
