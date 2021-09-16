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
            ->select('users.stb','users.username','users.name','users.angkatan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->where('users.name', 'like', '%'.$request->cari.'%')
            ->where('users.angkatan', $request->angkatan)
            ->paginate(15);
        } else if ($request->cari != '' && $request->jurusan != '') {
            $data = DB::table('users')
            ->select('users.stb','users.username','users.name','users.angkatan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->where('users.name', 'like', '%'.$request->cari.'%')
            ->where('users.jurusan_id', $request->jurusan)
            ->paginate(15);
        } else if ($request->cari != '') {
            $data = DB::table('users')
            ->select('users.stb','users.username','users.name','users.angkatan','users.email','users.alamat','users.nohp','users.perusahaan','users.jabatan','users.alamat_perusahaan')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
            ->where('users.is_active', '1')
            ->where('users.name', 'like', '%'.$request->cari.'%')
            ->paginate(15);
        } else {
            $data = DB::table('users')
            ->select('users.stb','users.username','users.name','users.angkatan','')
            ->where('users.is_active', '1')
            ->join('jurusans', 'users.jurusan_id', '=', 'jurusans.id')
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
