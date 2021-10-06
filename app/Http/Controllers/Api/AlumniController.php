<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
class AlumniController extends Controller
{
    public function index(Request $request) 
    {
        if ($request->cari != '' && $request->angkatan != '') {
            $data = DB::table('users')
            ->select('users.id','users.stb','users.username','users.name','users.angkatan','jurusans.nama as jurusan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->where('users.name', 'like', '%'.$request->cari.'%')
            ->where('users.angkatan', $request->angkatan)
            ->orderBy('users.angkatan', 'desc') //terbaru
            ->paginate(15);
        } else if ($request->cari != '' && $request->jurusan != '') {
            $data = DB::table('users')
            ->select('users.id','users.stb','users.username','users.name','users.angkatan','jurusans.nama as jurusan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->where('users.name', 'like', '%'.$request->cari.'%')
            ->where('users.jurusan_id', $request->jurusan)
            ->orderBy('users.angkatan', 'desc') //terbaru
            ->paginate(15);
        } else if ($request->cari != '') { // jika cari tidak kosong
            $data = DB::table('users')
            ->select('users.id','users.stb','users.username','users.name','users.angkatan','jurusans.nama as jurusan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->where('users.name', 'like', '%'.$request->cari.'%')
            ->orderBy('users.angkatan', 'desc') //terbaru
            ->paginate(15);
        } else if ($request->angkatan != '') { // jika angkatan tidak kosong
            $data = DB::table('users')
            ->select('users.id','users.stb','users.username','users.name','users.angkatan','jurusans.nama as jurusan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->where('users.angkatan', $request->angkatan)
            ->orderBy('users.angkatan', 'desc') //terbaru
            ->paginate(15);
        } else if ($request->jurusan != '') { // jika jurusan tidak kosong
            $data = DB::table('users')
            ->select('users.id','users.stb','users.username','users.name','users.angkatan','jurusans.nama as jurusan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->where('users.jurusan_id', $request->jurusan)
            ->orderBy('users.angkatan', 'desc') //terbaru
            ->paginate(15);
        } else {
            $data = DB::table('users')
            ->select('users.id','users.stb','users.username','users.name','users.angkatan','jurusans.nama as jurusan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->orderBy('users.angkatan', 'desc') //terbaru
            ->paginate(15);
        }
        return response()->json([
            'status' => true,
            'message'   => 'Alumni limit 15 data', 
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
}
