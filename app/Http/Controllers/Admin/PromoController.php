<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Promo;
use DataTables;
class PromoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.manage-promo.index');
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'     => 'required|string|max:200',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072',
        ]);
        $data = new Promo;
        $data->nama = $request->nama;
        $data->url = $request->url;
        $gambar = $request->file('gambar');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }
        $data->save();
        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Promo.'
        );
    }

    public function delete($id)
    {
        $data = Promo::find($id);
        if ($data->gambar && file_exists(storage_path('app/public/' . $data->gambar))) {
            \Storage::delete('public/' . $data->gambar);
        }
        $data->delete();
        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menghapus Promo.'
        );
    }

    public function tablePromo() // api table promo untuk datatable
    {
        $data = Promo::get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <button class='btn btn-danger btn-xs'
            title='Hapus Promo' 
            href='delete-promo/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->editColumn('gambar', function ($data) {
            return "<img src='/storage/".$data->gambar."' width='70px' height='70px'>";
        })
        ->editColumn('url', function ($data) {
            return "<a href='".$data->url."'>".$data->url."</a>";
        })
        ->rawColumns(['gambar','action','url'])
        ->addIndexColumn() 
        ->make(true);
    }
}
