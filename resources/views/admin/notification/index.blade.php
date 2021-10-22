@extends('layouts.template')

@section('title')
Notification
@endsection

@section('css')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('datatables.min.css')}}"/>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
	
	</div>
</div>
<!-- /.content-header -->
<section class="content">
	<div class="row">
		<div class="col-12">
			@if(session('success'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Berhasil Menambah Berita !</strong> <a href="{{route('berita.edit', session('success'))}}" class="alert-anchor">Sunting</a> atau <a href="{{route('berita.show', session('success'))}}" class="alert-anchor">Preview</a>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@elseif(session('error'))
			<div class="alert alert-danger">
				{{session('error')}}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@endif
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Whoops!</strong>
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>

			</div>
			@endif

			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><i class="fa fa-newspaper"></i> Riwayat Pengiriman Notifikasi</h2>
				</div>
				<div class="card-body">
					<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-tambah-notifikasi">
						<i class="fas fa-plus"></i> Kirim Notifikasi
					</button>
					<br>
					<br>
					<div class="table-responsive-sm">
						<table class="table table-bordered" style="width:100% !important; " id="tabel_notification">
							<thead>
								<tr>
									<th>No.</th>
									<th>Judul</th>
									<th>Deskripsi</th>
									<th>Waktu</th>
								</tr>
							</thead>  
							<tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Modal -->
	<div class="modal fade" id="modal-tambah-notifikasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Kirimkan notifikasi ke seluruh pengguna</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="" method="post" id="add-notification">
					@csrf
					<div class="modal-body">
						<div class="form-group">
							<label for="exampleInputEmail1">Judul</label>
							<input type="text" class="form-control" name="judul">
						</div>
						<div class="form-group">
							<label for="exampleInputEmail1">Deskripsi</label>
							<input type="text" class="form-control" name="deskripsi">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Kirim Notifikasi</button>
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
$('#add-notification').submit(function(e){ // tambah alumni
	e.preventDefault();

	var request = new FormData(this);
	var endpoint= '{{route("notification.store")}}';
	$.ajax({
		url: endpoint,
		method: "POST",
		data: request,
		contentType: false,
		cache: false,
		processData: false,
		success:function(data){
			$('#add-notification')[0].reset();
			$('#modal-tambah-notifikasi').modal('hide');
			$('#tabel_notification').DataTable().ajax.reload();
			success(data.status, data.pesan);
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

table = $(document).ready(function(){
		$('#tabel_notification').DataTable({
			"processing": true,
			"serverSide": true,
			"deferRender": true,
			"ordering": true,
			"order": [[ 0, 'desc' ]],
			"aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
			"ajax":  {
                "url":  '{{route("table.notification")}}', // URL file untuk proses select datanya
                "type": "GET"
            },
            "columns": [
            { data: 'DT_RowIndex', name:'DT_RowIndex'},
            { "data": "judul" },
            { "data": "deskripsi" },
            { "data": "created_at" },
            ]
        });
	});

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

function success(status, pesan) {
	Swal.fire({
		type: status,
		title: pesan,
		showConfirmButton: true,
		button: "Ok"
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
