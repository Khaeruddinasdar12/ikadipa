<?php

use Illuminate\Database\Seeder;

class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_beritas')->insert([
            'nama'  => 'pasar',
        ]);

        DB::table('kategori_beritas')->insert([
            'nama'  => 'market',
        ]);

        DB::table('kategori_beritas')->insert([
            'nama'  => 'saham',
        ]);
    }
}
