@extends('layouts.template')

@section('title') Edit Event @endsection

@section('css')
<link rel="stylesheet" href="{{ asset('admins/plugins/summernote/summernote-bs4.css') }}">
<style type="text/css">
.alert-warning{
	color: #856404;
	background-color: #fff3cd;
	border-color: #ffeeba;
}

.alert-success {
	color: #155724;
	background-color: #d4edda;
	border-color: #c3e6cb; 
}

.alert-danger {
	color: #721c24;
	background-color: #f8d7da;
	border-color: #f5c6cb;
}
.alert-anchor {
	color: blue !important;
}
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark"><i class="fa fa-calendar-edit"></i> Edit Event</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Event</li>
					<li class="breadcrumb-item active">Edit Event</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-12">
				@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Berhasil Mengubah Event !</strong>
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
					<strong>Whoops!</strong> Foto maksimal 2MB<br><br>
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
					
				</div>
				@endif
				<div class="card card-secondary card-outline">
					<form method="post" enctype="multipart/form-data" action="{{route('event.update', $data->id)}}">
						<div class="card-header">
							<h2 class="card-title"><i class="fa fa-calendar-plus"></i> Edit Event</h2>
							<button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Update</button>
						</div>
						<div class="card-body">
							@csrf
							{{ method_field('PUT') }}
							<div class="row">
								<div class="col-6">
									<label>Nama Event</label>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="masukkan nama event" name="nama" value="{{old('nama', $data->nama)}}">
									</div>
								</div>
								<div class="col-6">
									<label>Lokasi Event</label>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="masukkan lokasi event" name="lokasi" value="{{old('lokasi', $data->lokasi)}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="row">
										<div class="col-6">
											<label>Tanggal Mulai</label>
											<div class="form-group">
												<input type="date" class="form-control" name="date_start" min="<?php echo date('Y-m-d'); ?>" value="{{old('date_start', $data->date_start)}}" id="date_start" onchange="cekTanggalMulai()">
											</div>
										</div>
										<div class="col-6">
											<label>Tanggal Berakhir</label>
											<div class="form-group">
												<input type="date" class="form-control" name="date_end" min="<?php echo date('Y-m-d'); ?>" value="{{old('date_end', $data->date_end)}}" id="date_end" onchange="cekTanggal()">
											</div>
										</div>
									</div>
								</div>
								<div class="col-6">
									<label>Gambar</label>
									<input type="file" class="form-control-file" onchange="tampilkanPreview(this,'preview')" accept="image/*" name="gambar">
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="row">
										<div class="col-6">
											<label>Waktu Mulai</label>
											<div class="form-group">
												<input type="text" class="form-control" name="time_start" placeholder="ex. 08:30 WITA" value="{{old('time_start', $data->time_start)}}">
											</div>
										</div>
										<div class="col-6">
											<label>Waktu Berakhir</label>
											<div class="form-group">
												<input type="text" class="form-control" name="time_end" placeholder="ex. 09:30 WITA" value="{{old('time_end', $data->time_end)}}">
											</div>
										</div>
									</div>
								</div>
								<div class="col-6">
									<label>Preview</label>
									<div class="form-group">
										<img id="preview" src="{{asset('storage/'.$data->gambar)}}" width="90px" height="90px">
									</div>
								</div>
								
							</div>
							<textarea id="summernote" name="deskripsi">
								{{old('deskripsi', $data->deskripsi)}}
							</textarea>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->


@endsection

@section('js')
<script src="{{asset('admins/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script>
	function cekTanggalMulai() {
		var start = document.getElementById("date_start").value;
		var end = document.getElementById("date_end").value;
		if(end != '') {
			if (new Date(start) > new Date(end)) {
				gagal('Tanggal mulai', 'Tanggal mulai tidak boleh lebih dari tanggal akhir');
				document.getElementById("date_start").value = '';
			}
		}
	}

	function cekTanggal() {
		var start = document.getElementById("date_start").value;
		var end = document.getElementById("date_end").value;
		if(start == '') {
			document.getElementById("date_end").value = '';
			gagal('Tanggal mulai', 'Pilih tanggal mulai terlebih dahulu');
		} else if(new Date(start) > new Date(end)) {
			gagal('Tanggal mulai', 'Tanggal mulai tidak boleh lebih dari tanggal akhir');
		}
	}

	function tampilkanPreview(gambar, idpreview) {
    //membuat objek gambar
    var gb = gambar.files;
    //loop untuk merender gambar
    for (var i = 0; i < gb.length; i++) {
      //bikin variabel
      var gbPreview = gb[i];
      var imageType = /image.*/;
      var preview = document.getElementById(idpreview);
      var reader = new FileReader();
      if (gbPreview.type.match(imageType)) {
        //jika tipe data sesuai
        preview.file = gbPreview;
        reader.onload = (function(element) {
        	return function(e) {
        		element.src = e.target.result;
        	};
        })(preview);
        //membaca data URL gambar
        reader.readAsDataURL(gbPreview);
      } else {
        //jika tipe data tidak sesuai
        alert("Type file tidak sesuai. Khusus image.");
      }
    }
  }

  $(function () {
  	
    // Summernote
    $('#summernote').summernote({
    	placeholder: 'Masukkan deskripsi event',
    	height: 200
    })

  })
</script>
@endsection