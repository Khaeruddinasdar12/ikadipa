@extends('layouts.template')

@section('title') Detail Berita @endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark"></i> Detail Berita</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Berita</li>
					<li class="breadcrumb-item active">Detail Berita</li>
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
				<div class="card card-secondary card-outline">
					<div class="card-header">
						<h2 class="card-title"><i class="fa fa-newspaper"></i> Detail Berita</h2>
						<a href="{{route('berita.edit', ['id' => $data->id])}}" class="btn btn-secondary float-right"><i class="fa fa-edit"></i> Sunting</a>
					</div>
					<div class="card-body">

						<div class="row">
							<div class="col-md-8">
								<h4>{{$data->judul}}</h4>
								@if($data->gambar != '')
								<img src="{{asset('storage/'.$data->gambar)}}" class="img-fluid mx-auto d-block" alt="Responsive image" height="200px" width="300">
								@endif
								{!!$data->isi!!}
							</div>
							<div class="col-md-4">
								<label>Kategori</label>
								<h6>{{$data->kategori}}</h6>
								<label>Ditulis Oleh</label>
								<h6>{{$data->admin}}</h6>
								<label>Ditulis Pada</label>
								<h6>{{$data->created_at}} WITA</h6>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->


@endsection