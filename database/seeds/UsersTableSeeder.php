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
            'email' => 'rcrdmedina6@gmail.com',
            'nombre' => 'Ricardo',
            'apellido' => 'Medina',
            'password' => \Hash::make('1234'),
            'status' => '1',
            'rol' => '1',
         ));
    }
}
