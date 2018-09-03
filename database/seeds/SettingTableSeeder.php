<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Insert Data to Setting
         */
        DB::table('setting')->insert([
        	[
        		'nama_perusahaan' => 'Ardye Mart',
        		'alamat' => 'Jl. Pramuka Rajabasa',
        		'telepon' => '089696509522',
        		'logo' => 'logo.png',
        		'kartu_member' => 'card.png',
        		'diskon_member' => 10,
        		'tipe_nota' => 0,
        		'created_at' => now()
        	]
        ]);
    }
}
