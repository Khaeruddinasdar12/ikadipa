<?php

use Illuminate\Database\Seeder;
use App\Provinsi;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withHeaders([
            'key' => config('app.raja_ongkir_key')
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces = $response['rajaongkir']['results'];

        foreach($provinces as $province) {
        	$data_province[] = [
        		'id' => $province['province_id'],
        		'nama_provinsi' => $province['province']
        	];
        }
        Provinsi::insert($data_province);
    }
}
