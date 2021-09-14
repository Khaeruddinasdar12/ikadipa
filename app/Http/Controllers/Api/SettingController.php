<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jurusan;
use App\Provinsi;
use App\Kota;
use App\KategoriPerusahaan;
use Validator;
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

    public function kota(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provinsi_id' => 'required|numeric',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        $data = Kota::where('provinsi_id', $request->provinsi_id)->get();
        
        return response()->json([
            'status'    => true,
            'message'   => 'Kota Berdasarkan Id Provinsi',
            'data' => $data
        ]); 
    }
}
