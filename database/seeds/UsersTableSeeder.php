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
        /**
         * Insert Data to Users Table
         */
        DB::table('users')->insert([
        	[
        		'name' => 'Ardye Amando Pratama',
        		'email' => 'ardye.medsos@gmail.com',
        		'password' => bcrypt('naruto'),
        		'foto' => 'admin.png',
        		'level' => 1,
        		'created_at' => now()
        	],
        	[
        		'name' => 'Desta Riani',
        		'email' => 'destarianimunaf@gmail.com',
        		'password' => bcrypt('sasuke'),
        		'foto' => 'kasir.png',
        		'level' => 2,
        		'created_at' => now()
        	]
        ]);
    }
}
