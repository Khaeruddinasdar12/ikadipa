<?php

use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    public function run()
    {
        DB::table('alumnis')->insert([
            'stb' => '122796',
            'name' => 'Khaeruddin Asdar',
            'angkatan' => '2017',
            'jurusan_id' => '1'
        ]);

        DB::table('alumnis')->insert([
            'stb' => '122797',
            'name' => 'M Ibnu Muntzir',
            'angkatan' => '2017',
            'jurusan_id' => '1'
        ]);
    }
}
