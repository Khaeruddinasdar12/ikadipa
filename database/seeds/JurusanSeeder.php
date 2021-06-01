<?php

use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jurusans')->insert([
        	'kode'	=> 'TI',
	        'nama'  => 'Teknik Informatika',
		]);

		DB::table('jurusans')->insert([
			'kode'	=> 'SI',
	        'nama'  => 'Sistem Informasi',
		]);

		DB::table('jurusans')->insert([
			'kode'	=> 'MI',
	        'nama'  => 'Manajemen Informatika',
		]);

		DB::table('jurusans')->insert([
			'kode'	=> 'RPL',
	        'nama'  => 'Rekayasa Perangkat Lunak',
		]);

		DB::table('jurusans')->insert([
			'kode'	=> 'DG',
	        'nama'  => 'Digital Bisnis',
		]);

		DB::table('jurusans')->insert([
			'kode'	=> 'KWH',
	        'nama'  => 'Kewirausahaan',
		]);
    }
}
