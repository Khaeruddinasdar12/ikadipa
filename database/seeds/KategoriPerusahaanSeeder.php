<?php

use Illuminate\Database\Seeder;

class KategoriPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_perusahaans')->insert([
	        'nama'  => 'peternakan',
		]);

		DB::table('kategori_perusahaans')->insert([
	        'nama'  => 'perikanan',
		]);

		DB::table('kategori_perusahaans')->insert([
	        'nama'  => 'hukum',
		]);
    }
}
