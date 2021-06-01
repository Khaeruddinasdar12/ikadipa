<?php

use Illuminate\Database\Seeder;
use App\Kota;

class KotaSeeder extends Seeder
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
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities = $response['rajaongkir']['results'];

        foreach($cities as $city) {
        	$data_city[] = [
        		'id' => $city['city_id'],
        		'provinsi_id' => $city['province_id'],
        		'tipe' => $city['type'],
        		'nama_kota' => $city['city_name']
        	];
        }
        Kota::insert($data_city);
    }
}
