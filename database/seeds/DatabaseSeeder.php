<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->call(UsersTableSeeder::class);
      $this->call(TypeVisitsTableSeeder::class);
      $this->call(TypeGuestsTableSeeder::class);
      $this->call(RolesTableSeeder::class);
      $this->call(MotiveVisitsTableSeeder::class);
      $this->call(EnterprisesTableSeeder::class);
      $this->call(DestinationsTableSeeder::class);
    }
}
