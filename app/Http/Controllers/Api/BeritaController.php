<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Berita;
use App\KategoriBerita;
use DB;
use Validator;
class BeritaController extends Controller
{
    public function berita(Request $request)
    {
        $data = Berita::select('beritas.id', 'beritas.judul', 'beritas.gambar', 'beritas.created_at', DB::raw('group_concat(concat(kategori_beritas.nama)SEPARATOR ", ") as kategori'))
        ->leftjoin("kategori_beritas",\DB::raw("FIND_IN_SET(kategori_beritas.id,beritas.kategori)"),">",\DB::raw("'0'"))
        ->groupBy('beritas.id')
        ->paginate(8);

        return response()->json([
            'status' => true,
            'message'   => 'List Berita, limit 10 data',
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

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'berita_id' => 'required|numeric',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $data = 
        Berita::select('beritas.id', 'beritas.judul', 'beritas.gambar', 'beritas.created_at', 'beritas.isi', DB::raw('group_concat(concat(kategori_beritas.nama)SEPARATOR ", ") as kategori'))
        ->leftjoin("kategori_beritas",\DB::raw("FIND_IN_SET(kategori_beritas.id,beritas.kategori)"),">",\DB::raw("'0'"))
        ->groupBy('beritas.id')
        ->where('beritas.id', $request->berita_id)
        ->get();

        if($data == '') {
            return response()->json([
                'status' => false,
                'message' => 'id berita tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => true,
            'message'   => 'Detail Berita',
            'data'  => $data
        ]);
    }

    public function kategori()
    {
        $data = KategoriBerita::select('id', 'nama')->get();
        return response()->json([
            'status' => true,
            'message'   => 'List Kategori Berita',
            'data'  => $data
        ]);
    }

    public function kategoriBerita(Request $request)
    {
        $data = DB::table('beritas')
        ->whereRaw('FIND_IN_SET("'.$request->kategori_id.'",kategori)')
        ->get();
        if($data == '') {
            return response()->json([
                'status' => false,
                'message' => 'id kategori berita tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => true,
            'message'   => 'List Berita per Kategori',
            'data'  => $data
        ]);
    }
}
