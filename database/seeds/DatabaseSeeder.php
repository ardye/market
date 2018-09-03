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
    	/** Call Class Seeder */
         $this->call([
         	UsersTableSeeder::class,
         	SettingTableSeeder::class
         ]);
    }
}
