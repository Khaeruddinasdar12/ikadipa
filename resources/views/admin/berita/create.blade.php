@extends('layouts.template')

@section('title') Tambah Berita @endsection

@section('css')
<link rel="stylesheet" href="{{ asset('admins/plugins/summernote/summernote-bs4.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('admins/plugins/daterangepicker/daterangepicker.css')}}"> -->
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
				<h1 class="m-0 text-dark">Tambah Berita</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Berita</li>
					<li class="breadcrumb-item active">Tambah Berita</li>
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
					<strong>Whoops!</strong> Foto maksimal 2MB<br><br>
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
					
				</div>
				@endif
				<div class="card card-secondary card-outline">
					<form method="post" enctype="multipart/form-data" action="{{route('berita.store')}}">
						<div class="card-header">
							<h2 class="card-title"><i class="fa fa-newspaper"></i> Tambah Berita</h2>
							<button type="submit" class="btn btn-primary float-right"><i class="fa fa-paper-plane"></i> Publish</button>
						</div>
						<div class="card-body">
							@csrf
							<div class="row">
								<div class="col-12">
									<label>Judul Berita</label>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="masukkan judul berita" name="judul" value="{{old('judul')}}">
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
									<label>Kategori Berita</label>									
									<div class="form-group">
										@foreach($ktg as $ktgr)
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="kategori[]" value="{{$ktgr->id}}" @if(is_array(old('kategori')) && in_array($ktgr->id, old('kategori'))) checked @endif>
											<label class="form-check-label">{{$ktgr->nama}}</label>
										</div>
										@endforeach
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