<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Wirausaha;

class WirausahaController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'               => 'required|numeric',
            'kategori_perusahaan_id'   => 'required|numeric',
            'alamat_id'   => 'required|numeric',
            'lokasi'   => 'required|string',
            'nama'   => 'required|string',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        
        if($this->login($request->user_id) == false) {
            return $this->error;
        }

        $data = new Wirausaha;
        $data->nama = $request->nama;
        $data->lokasi = $request->lokasi;
        $data->user_id = $request->user_id;
        $data->alamat_id = $request->alamat_id;
        $data->kategori_id = $request->kategori_perusahaan_id;
        $data->save();

        return response()->json([
            'status'    => true,
            'message'   => 'Data wirausaha ditambahkan',
        ]);

    }

    private $user;
    private $error;

    public function login($id)
    {
        $this->user = User::find($id);
        if($this->user == '') {
            $this->error = [
                'status'    => false,
                'message'   => 'Id Alumni Tidak ditemukan'
            ]; 
            return false;
        } else if ($this->user->is_active != '1') {
            $this->error = [
                'status'    => false,
                'message'   => 'Anda Bukan Alumni Dipa'
            ]; 
            return false;
        }
        return true;
    }
}
