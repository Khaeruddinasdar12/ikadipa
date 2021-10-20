<?php

namespace App\Imports;

use App\Alumni;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class AlumniImport implements ToModel
{
    public function model(array $row)
    {
        return new Alumni([
            'stb'     => $row[0],
            'name'    => $row[1],
            'angkatan' => $row[2],
            'jurusan_id' =>  $row[3],
        ]);
    }
}
