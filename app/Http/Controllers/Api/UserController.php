<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
// use App\Wirausaha;
use DB;
use Auth;
class UserController extends Controller
{

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL ) 
        ? 'email' 
        : 'username';

        $request->merge([
            $login_type => $request->input('email')
        ]);

        $credentials = $request->only($login_type, 'password');

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'status'    => false,
                'message'   => 'Kesalahan email atau password',
            ]); 
        } 

        $user = Auth::user();
        if($user->is_active == '0') {
            return response()->json([
                'status'    => true,
                'message'   => 'Akun Anda Masih Tahap Validasi',
                'is_active' => $user->is_active, //0 

            ]);
        } else if($user->is_active == 'tolak') {
            return response()->json([
                'status'    => true,
                'message'   => $user->komentar, 
                'is_active' => $user->is_active, //tolak
            ]);
        } else {
            return response()->json([
                'status'    => true,
                'message'   => 'Berhasil login user',
                'id'        => $user->id,
                'nama'      => $user->name,
                'email'     => $user->email,
                'is_active' => $user->is_active, 
            ]);
        }


    }

    public function register(Request $request) //menambah data admin
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        $validator = Validator::make($request->all(), [
            'stb'  => 'required|numeric|digits:6|unique:users',
            'angkatan'  => 'required|numeric|digits:4',
            'nama'      => 'required|string',
            'jkel'      => 'required|string',
            'username'  => 'required|string|without_spaces|unique:users',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'nohp'      => 'required|string',
            'jurusan_id'=> 'required|numeric',
            'alamat_id' => 'required|numeric',
            'alamat_lengkap' => 'required|string',
            'kategori_perusahaan_id' => 'numeric',
            'perusahaan'    => 'string',
            'jabatan'   => 'string',
            'alamat_perusahaan' => 'string',

        ], [
            'username.without_spaces' => 'tidak boleh menggunakan spasi'
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
              'status' => false,
              'message' => $message
          ]);
        }

        $data = new User;
        $data->stb      = $request->stb;
        $data->angkatan = $request->angkatan;
        $data->name     = $request->nama;
        $data->jkel     = $request->jkel;
        $data->username = $request->username;
        $data->email    = $request->email;
        $data->password = bcrypt($request->password);
        $data->nohp     = $request->nohp;
        $data->alamat     = $request->alamat_lengkap;
        $data->alamat_id  = $request->alamat_id;
        $data->jurusan_id = $request->jurusan_id;


        if($request->perusahaan && $request->jabatan && $request->kategori_perusahaan_id && $request->alamat_perusahaan_id && $request->alamat_perusahaan) {
            $data->perusahaan = $request->perusahaan;
            $data->kategori_id = $request->kategori_perusahaan_id;
            $data->jabatan = $request->jabatan;

            $data->alamat_perusahaan = $request->alamat_perusahaan;
        }

        $data->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mendaftar, data Anda akan segera divalidasi',
            'nama'  => $data->name,
            'username' => $data->username,
            'email' => $data->email,
            'nohp'  => $data->nohp,
        ]);
    }

    public function myprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'               => 'required|numeric',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        $data = DB::table('users')
        ->select('users.stb','users.username','users.name','users.angkatan','jurusans.nama as jurusan','users.email','users.alamat','provinsis.nama_provinsi','kotas.tipe','kotas.nama_kota','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
        ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
        ->join('kotas', 'users.alamat_id', '=', 'kotas.id')
        ->join('provinsis', 'kotas.provinsi_id', '=', 'provinsis.id')
        ->where('users.id', $request->user_id)
        ->first();
        if($data == '') {
            return response()->json([
                'status'    => false,
                'message'   => 'Id alumni tidak ditemukan',
            ]);
        }
        return response()->json([
            'status'    => true,
            'message'   => 'Profile Alumni',
            'data'      => $data
        ]);

    }
}
