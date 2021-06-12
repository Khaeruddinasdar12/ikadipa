<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jurusan;
use App\KategoriPerusahaan;
use DataTables;
class SettingController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
		$jrs = Jurusan::orderBy('created_at', 'desc')->paginate(10);
		$ktg = KategoriPerusahaan::orderBy('created_at', 'desc')->paginate(10);
		return view('admin.setting', [
			'jrs' => $jrs,
			'ktg' => $ktg
		]);
	}

	public function postJurusan(Request $request)
	{
		$messages = [
			'required' => ':attribute harus diisi',
		];

		$attributes = [
			'kode' => 'kode jurusan',
			'nama' => 'nama jurusan',
		];
		$validasi = $this->validate($request, [
			'kode'	=> 'required|string|unique:jurusans',
			'nama'  => 'required|string'
		], $messages, $attributes);

		$data = new Jurusan;
		$data->kode = $request->kode;
		$data->nama = $request->nama;
		$data->save();

		return $arrayName = array(
			'status' => 'success',
			'pesan' => 'Berhasil Menambah Jurusan.'
		);
	}

	public function editJurusan(Request $request)
	{
		$messages = [
			'required' => ':attribute harus diisi',
		];

		$attributes = [
			'kode' => 'kode jurusan',
			'nama' => 'nama jurusan',
		];

		$data = Jurusan::find($request->hidden_id);
		if($data == '') {
			return $arrayName = array(
				'status' => 'error',
				'pesan' => 'Data jurusan tidak ditemukan'
			);
		}
		if($data->kode != $request->kode) {
			$validasi = $this->validate($request, [
				'kode'	=> 'required|string|unique:jurusans',
				'nama'  => 'required|string'
			], $messages, $attributes);

			$data->kode = $request->kode;
		}

		$data->nama = $request->nama;
		$data->save();

		return $arrayName = array(
			'status' => 'success',
			'pesan' => 'Berhasil Mengubah Jurusan.'
		);
	}

	public function postKategori(Request $request)
	{
		$messages = [
			'required' => ':attribute harus diisi',
		];

		$attributes = [
			'nama' => 'nama kategori perusahaan',
		];
		$validasi = $this->validate($request, [
			'nama'  => 'required|string|unique:kategori_perusahaans'
		], $messages, $attributes);

		$data = new KategoriPerusahaan;
		$data->nama = $request->nama;
		$data->save();

		return $arrayName = array(
			'status' => 'success',
			'pesan' => 'Berhasil Menambah Jurusan.'
		);
	}

	public function editKategori(Request $request)
	{
		$validasi = $this->validate($request, [
			'nama'  => 'required|string|unique:kategori_perusahaans'
		]);

		$data = KategoriPerusahaan::find($request->hidden_id);
		if($data == '') {
			return $arrayName = array(
				'status' => 'error',
				'pesan' => 'Data kategori perusahaan tidak ditemukan'
			);
		}
		$data->nama = $request->nama;
		$data->save();

		return $arrayName = array(
			'status' => 'success',
			'pesan' => 'Berhasil Mengubah Kategori Perusahaan.'
		);
	}

	public function deleteJurusan(Request $request, $id) //delete jurusan
	{
		$data = Jurusan::find($request->id);
		if($data == '') {
			return $arrayName = array(
				'status' => 'error',
				'pesan' => 'Data jurusan tidak ditemukan'
			);
		}
		$data->delete();

		return $arrayName = array(
			'status' => 'success',
			'pesan' => 'Berhasil Menghapus Jurusan.',
			'table' => 'jurusan'
		);
	}

	public function deleteKategori(Request $request, $id) //delete kategori
	{
		$data = KategoriPerusahaan::find($request->id);
		if($data == '') {
			return $arrayName = array(
				'status' => 'error',
				'pesan' => 'Data kategori perusahaan tidak ditemukan'
			);
		}
		$data->delete();

		return $arrayName = array(
			'status' => 'success',
			'pesan' => 'Berhasil Menghapus Kategori Perusahaan.',
			'table' => 'kategori'
		);
	}

	public function tableKategori() // api table kategori perusahaan untuk datatable
	{
		$data = KategoriPerusahaan::select('id', 'nama')
		->orderBy('created_at', 'desc')
		->get();

		return Datatables::of($data)
		->addColumn('action', function ($data) {
			return "
			<a href='' class='btn btn-success btn-xs'
			data-toggle='modal' 
			data-target='#modal-edit-kategori'
			title='edit kategori'
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

    public function tableJurusan() // api table jurusan untuk datatable
    {
    	$data = Jurusan::select('id', 'kode', 'nama')
    	->orderBy('created_at', 'desc')
    	->get();

    	return Datatables::of($data)
    	->addColumn('action', function ($data) {
    		return "
    		<a href='' class='btn btn-success btn-xs'
    		data-toggle='modal' 
    		data-target='#modal-edit-jurusan'
    		title='edit jurusan'
    		data-id='".$data->id."'
    		data-nama='".$data->nama."'
    		data-kode='".$data->kode."'>
    		<i class='fa fa-edit'></i>
    		</a>

    		<button class='btn btn-danger btn-xs'
    		title='Hapus Jurusan' 
    		href='delete-jurusan/".$data->id."'
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
