<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Wirausaha;
use DB;
class WirausahaController extends Controller
{
    public function index(Request $request)
    {
        if($request->cari != '') {
            $data = DB::table('wirausahas')
            ->select('wirausahas.nama','wirausahas.alamat_lengkap','wirausahas.lokasi','kategori_perusahaans.nama as nama_kategori','users.name as nama_pemilik','kotas.tipe','kotas.nama_kota','provinsis.nama_provinsi')
            ->join('users', 'wirausahas.user_id', '=', 'users.id')
            ->join('kotas', 'wirausahas.alamat_id', '=', 'kotas.id')
            ->join('provinsis', 'kotas.provinsi_id', '=', 'provinsis.id')
            ->join('kategori_perusahaans', 'wirausahas.kategori_id', '=', 'kategori_perusahaans.id')
            ->where('users.name', 'like', '%'.$request->cari.'%')
            ->paginate(10);
        } else {
            $data = DB::table('wirausahas')
            ->select('wirausahas.nama','wirausahas.alamat_lengkap','wirausahas.lokasi','kategori_perusahaans.nama as nama_kategori','users.name as nama_pemilik','kotas.tipe','kotas.nama_kota','provinsis.nama_provinsi')
            ->join('users', 'wirausahas.user_id', '=', 'users.id')
            ->join('kotas', 'wirausahas.alamat_id', '=', 'kotas.id')
            ->join('provinsis', 'kotas.provinsi_id', '=', 'provinsis.id')
            ->join('kategori_perusahaans', 'wirausahas.kategori_id', '=', 'kategori_perusahaans.id')
            ->paginate(10);
        }

        return response()->json([
            'status' => true,
            'message'   => 'Data Wirausaha limit 10 data', 
            'data'  => $data->items(),
            'current_page' => $data->currentPage(),
            'first_page_url' => $data->url(1),
            'from' => $data->firstItem(),
            'last_page' => $data->lastPage(),

            'last_page_url' => $data->url($data->lastPage()) ,
            'next_page_url' => $data->nextPageUrl(),
            'path'  => $data->path(),
            'per_page' => $data->perPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'to' => $data->count(),
            'total' => $data->total()
        ]);

    }

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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'               => 'required|numeric',
            'wirausaha_id'               => 'required|numeric',
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
        
        // if($this->login($request->user_id) == false) {
        //     return $this->error;
        // }

        $data = Wirausaha::find($request->wirausaha_id);
        if($data == '') {
            return response()->json([
                'status' => false,
                'message' => 'id tidak ditemukan.'
            ]);
        }
        $data->nama = $request->nama;
        $data->lokasi = $request->lokasi;
        $data->user_id = $request->user_id;
        $data->alamat_id = $request->alamat_id;
        $data->kategori_id = $request->kategori_perusahaan_id;
        $data->save();

        return response()->json([
            'status'    => true,
            'message'   => 'Data wirausaha diubah',
        ]);

    }

    public function wirausaha(Request $request) // wirausaha per profile
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
        $data = DB::table('wirausahas')
        ->select('wirausahas.nama','wirausahas.alamat_lengkap','wirausahas.lokasi','kategori_perusahaans.nama as nama_kategori','kotas.tipe','kotas.nama_kota','provinsis.nama_provinsi')
        ->join('users', 'wirausahas.user_id', '=', 'users.id')
        ->join('kotas', 'wirausahas.alamat_id', '=', 'kotas.id')
        ->join('provinsis', 'kotas.provinsi_id', '=', 'provinsis.id')
        ->join('kategori_perusahaans', 'wirausahas.kategori_id', '=', 'kategori_perusahaans.id')
        ->where('users.id', $request->user_id)
        ->get();
        if($data == '') {
            return response()->json([
                'status'    => false,
                'message'   => 'Data Tidak Ditemukan',
            ]);
        }
        return response()->json([
            'status'    => true,
            'message'   => 'Profile Alumni',
            'data'      => $data
        ]);

    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'               => 'required|numeric',
            'wirausaha_id'   => 'required|numeric',
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

        $data = Wirausaha::find($request->wirausaha_id);
        if($data == '') {
            return response()->json([
                'status' => false,
                'message' => 'id wirausaha tidak ditemukan.'
            ]);
        }

        if($data->user_id == $request->user_id && $data->id == $request->wirausaha_id) {
            $data->delete();
            return response()->json([
                'status'    => true,
                'message'   => 'Berhasil menghapus wirausaha',
            ]);
        }

        return response()->json([
            'status'    => false,
            'message'   => 'data ini bukan milik Anda',
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
