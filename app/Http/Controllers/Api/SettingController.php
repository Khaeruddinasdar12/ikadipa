<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jurusan;
use App\Provinsi;
use App\Kota;
class SettingController extends Controller
{
    public function jurusan()
    {
        $data = Jurusan::select('id', 'kode', 'nama')->get();

        return $data;
    }

    public function provinsi()
    {
        $data = Provinsi::select('id', 'nama_provinsi')->get();

        return $data;
    }

    public function kota()
    {
        $data = Kota::get();

        return $data;
    }
}
