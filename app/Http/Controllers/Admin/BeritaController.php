<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\KategoriBerita;
use DataTables;

class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function kategori() //halaman kategori berita
    {
        return view('admin.berita.kategori');
    }

    public function postKategori(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string'
        ]);

        $data = new KategoriBerita;
        $data->nama = $request->nama;
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Kategori Berita.'
        );
    }

    public function editKategori(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string'
        ]);

        $data = KategoriBerita::find($request->hidden_id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Data kategori berita tidak ditemukan'
            );
        }
        $data->nama = $request->nama;
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Mengubah Kategori Berita.'
        );
    }

    public function deleteKategori(Request $request, $id) //delete kategori berita
    {
        $data = KategoriBerita::find($request->id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Data kategori berita tidak ditemukan'
            );
        }
        $data->delete();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menghapus Kategori Berita.'
        );
    }

    public function tableKategori() // api table kategori berita untuk datatable
    {
        $data = KategoriBerita::select('id', 'nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a class='btn btn-success btn-xs'
            data-toggle='modal' 
            data-target='#modal-edit-kategori'
            title='edit kategori berita'
            data-id='".$data->id."'
            data-nama='".$data->nama."'>
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Pengecer' 
            href='delete-kategori/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }
}
