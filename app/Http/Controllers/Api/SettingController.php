<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jurusan;
use App\Provinsi;
use App\Kota;
use App\KategoriPerusahaan;
class SettingController extends Controller
{
    public function kategoriPerusahaan()
    {
        $data = KategoriPerusahaan::select('id', 'nama')->get();
        
        return response()->json([
            'status'    => true,
            'message'   => 'Semua Kategori Perusahaan',
            'data' => $data
        ]); 
    }

    public function jurusan()
    {
        $data = Jurusan::select('id', 'kode', 'nama')->get();
        
        return response()->json([
            'status'    => true,
            'message'   => 'Jurusan provinsi',
            'data' => $data
        ]);  
    }

    public function provinsi()
    {
        $data = Provinsi::select('id', 'nama_provinsi')->get();

        return response()->json([
            'status'    => true,
            'message'   => 'Semua provinsi',
            'data' => $data
        ]); 
    }

    public function kota()
    {
        $data = Kota::get();
        
        return response()->json([
            'status'    => true,
            'message'   => 'Semua Kota',
            'data' => $data
        ]); 
    }
}
