@extends('layouts.template')

@section('title')
List Alumni
@endsection

@section('css')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('datatables.min.css')}}"/>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Data Alumni</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Data Alumni</li>
					<li class="breadcrumb-item active">Semua Alumni</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<!-- /.content-header -->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><i class="fa fa-newspaper"></i> Data Alumni</h2>
					<div class="card-tools">
						<form action="{{route('data.alumni')}}" method="get">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="cari" class="form-control float-right" placeholder="cari nama" value="{{ Request::get('cari') }}">

								<div class="input-group-append">
									<button type="submit" class="btn btn-default">
										<i class="fas fa-search"></i>
									</button>
								</div>
							</div>
						</form>
					</div>
					
				</div>
				
				<div class="card-body">
					<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-tambah-alumni">
						<i class="fas fa-plus"></i> Tambah Data
					</button>
					<br><br>
					<div class="table-responsive-sm">
						<table class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>STB</th>
									<th>Nama</th>
									<th>Angkatan</th>
									<th>Jurusan</th>
									<th>Action</th>
								</tr>
							</thead>  
							<tbody>
								@php $no = 1; @endphp
								@foreach($data as $dt)
								<tr>
									<td>{{$no++}}</td>
									<td>{{$dt->stb}}</td>
									<td>{{$dt->name}}</td>
									<td>{{$dt->angkatan}}</td>
									<td>{{$dt->jurusan->nama}}</td>
									<td><a href="{{route('edit.alumni', ['id' => $dt->id])}}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-edit"></i></a>
										<button href="{{route('delete.alumni', ['id' => $dt->id])}}" onclick="hapus_data()" id="del_id" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button></td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{$data->links()}}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="modal-tambah-alumni" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambah Data ALumni</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="" method="post" id="add-alumni">
				@csrf
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleInputEmail1">STB</label>
						<input type="text" class="form-control" placeholder="Stambuk" name="stb">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Nama</label>
						<input type="text" class="form-control" placeholder="Nama Lengkap Tanpa Gelar" name="nama">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Angkatan</label>
						<input type="text" class="form-control" placeholder="Angkatan (4 angka)" name="angkatan">
					</div>
					<div class="form-group">
						<label>Jurusan</label>
						<select class="form-control" name="jurusan">
							@foreach($jurusan as $jr)
							<option value="{{$jr->id}}">{{$jr->nama}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
$('#add-alumni').submit(function(e){ // tambah alumni
	e.preventDefault();

	var request = new FormData(this);
	var endpoint= '{{route("data.alumni")}}';
	$.ajax({
		url: endpoint,
		method: "POST",
		data: request,
		contentType: false,
		cache: false,
		processData: false,
		success:function(data){
			$('#add-alumni')[0].reset();
			berhasil(data.status, data.pesan);
		},
		error: function(xhr, status, error){
			var error = xhr.responseJSON; 
			if ($.isEmptyObject(error) == false) {
				$.each(error.errors, function(key, value) {
					gagal(key, value);
				});
			}
		} 
	}); 
});
		function hapus_data() { // menghapus jurusan
			$(document).on('click', '#del_id', function(){
				Swal.fire({
					title: 'Anda Yakin ?',
					text: "Anda tidak dapat mengembalikan data yang telah di hapus!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Ya, Lanjutkan Hapus!',
					timer: 6500
				}).then((result) => {
					if (result.value) {
						var me = $(this),
						url = me.attr('href'),
						token = $('meta[name="csrf-token"]').attr('content');
						$.ajax({
							url: url,
							method: "POST",
							data : {
								'_method' : 'DELETE',
								'_token'  : token
							},
							success:function(data){
								berhasil(data.status, data.pesan);
							},
							error: function(xhr, status, error){
								var error = xhr.responseJSON; 
								if ($.isEmptyObject(error) == false) {
									$.each(error.errors, function(key, value) {
										gagal(key, value);
									});
								}
							} 
						});
					}
				});
			});
		}

		function berhasil(status, pesan) {
			Swal.fire({
				type: status,
				title: pesan,
				showConfirmButton: true,
				button: "Ok"
			}).then(function(){ 
				location.reload();
			})
		}

		function gagal(key, pesan) {
			Swal.fire({
				type: 'error',
				title:  key + ' : ' + pesan,
				showConfirmButton: true,
				timer: 25500,
				button: "Ok"
			})
		}
	</script>
	@endsection
