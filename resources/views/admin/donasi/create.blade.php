@extends('layouts.template')

@section('title') Tambah Donasi @endsection

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
				<h1 class="m-0 text-dark">Donasi</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Donasi</li>
					<li class="breadcrumb-item active">Tambah Donasi</li>
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
					<strong>Berhasil Menambah Donasi !</strong> <a href="{{route('donasi.edit', session('success'))}}" class="alert-anchor">Sunting</a>
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
					<form method="post" enctype="multipart/form-data" action="{{route('donasi.store')}}">
						<div class="card-header">
							<h2 class="card-title"><i class="fa fa-hand-holding-usd"></i> Tambah Donasi</h2>
							<button type="submit" class="btn btn-primary float-right"><i class="fa fa-paper-plane"></i> Publish</button>
						</div>
						<div class="card-body">
							@csrf
							<div class="row">
								<div class="col-12">
									<label>Judul Donasi</label>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="masukkan judul donasi" name="judul" value="{{old('judul')}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="row">
										<div class="col-6">
											<label>Gambar Utama</label>
											<input type="file" class="form-control-file" onchange="tampilkanPreview(this,'preview')" accept="image/*" name="gambar">
										</div>
										<div class="col-6">
											<label>Gambar Preview</label>
											<div class="form-group">
												<img id="preview" src="{{asset('picture.png')}}" width="90px" height="90px">
											</div>
										</div>
									</div>
								</div>
								<div class="col-6">
									<label>Batas Akhir Donasi</label>									
									<div class="form-group">
										<input type="date" name="date_end" min="<?php echo date('Y-m-d'); ?>" class="form-control" value="{{old('date_end')}}">
									</div>
								</div>
							</div>
							<textarea id="summernote" name="isi">
								{{old('isi')}}
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
    	placeholder: 'Masukkan berita',
    	height: 400
    })

  })
</script>
@endsection