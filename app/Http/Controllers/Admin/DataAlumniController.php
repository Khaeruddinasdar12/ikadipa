<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Alumni;
use App\Jurusan;
use App\User;
class DataAlumniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $jurusan = Jurusan::get();
        if($request->cari != '') {
            $data = Alumni::with('jurusan')
            ->where('name', 'like', '%'.$request->cari.'%')
            ->orderBy('angkatan', 'desc')
            ->paginate(30);
        } else {
            $data = Alumni::with('jurusan')
            ->orderBy('angkatan', 'desc')
            ->paginate(30);
        }
        
        return view('admin.data-alumni.index', [
            'data' => $data,
            'jurusan' => $jurusan
        ]);
    }

    public function edit($id)
    {
        $jurusan = Jurusan::get();
        $data = Alumni::findOrFail($id);
        
        return view('admin.data-alumni.edit', [
            'data' => $data,
            'jurusan' => $jurusan
        ]);
    }

    public function update(Request $request, $id)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string',
            'angkatan' => 'required|numeric|digits:4',
            'jurusan' => 'required|numeric',
        ]);

        $data = Alumni::findOrFail($id);
        $data->name = $request->nama;
        $data->jurusan_id = $request->jurusan;
        $data->angkatan = $request->angkatan;
        $data->save();

        return redirect()->back()->with('success', 'Berhasil Mengubah Data Alumni');
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'stb'  => 'required|digits:6|unique:alumnis',
            'nama'  => 'required|string',
            'angkatan' => 'required|numeric|digits:4',
            'jurusan' => 'required|numeric',
        ]);

        $data = new Alumni;
        $data->stb = $request->stb;
        $data->name = $request->nama;
        $data->jurusan_id = $request->jurusan;
        $data->angkatan = $request->angkatan;
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Alumni.'
        );
    }

    public function destroy($id)
    {
        $data = Alumni::findOrFail($id);
        $data->delete();
        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Alumni.'
        );
    }

    public function cek($id)
    {
        $user = User::find($id);
        $cek = Alumni::with('jurusan:id,nama')
            ->where('name', 'like', '%'.$user->name.'%')
            ->where('angkatan', '=', $user->angkatan)
            ->where('stb', '=', $user->stb)
            ->where('jurusan_id', '=', $user->jurusan_id)
            ->first();

        if($cek != '') {
            return $arrayName = array(
                'status' => 'success',
                'pesan' => 'Terdapat Kecocokan Data',
                'data' => $cek
            );
        } else {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Tidak Ada Kecocokan'
            );
        }
        
    }
}
