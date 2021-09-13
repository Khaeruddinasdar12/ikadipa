@extends('layouts.template')

@section('title') Edit Alumni @endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Data Alumni</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item">Data Alumni</li>
					<li class="breadcrumb-item active">Edit Alumni</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-12">
				@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{session('success')}}
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
					<strong>Whoops!</strong><br>
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
					
				</div>
				@endif
				<div class="card card-secondary card-outline">
					<form method="post" action="{{route('update.alumni', ['id' => $data->id])}}">
						<div class="card-header">
							<h2 class="card-title"><i class="fa fa-user"></i> Edit Alumni</h2>
							<button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Update</button>
						</div>
						<div class="card-body">
							@csrf
							{{ method_field('PUT') }}
							<div class="row">
								<div class="col-12">
									<label>STB</label>
									<div class="form-group">
										<input type="text" class="form-control" disabled value="{{$data->stb}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<label>Nama Lengkap Tanpa Gelar</label>
									<div class="form-group">
										<input type="text" class="form-control" name="nama" value="{{old('nama', $data->name)}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<label>Angkatan (4 angka)</label>
									<div class="form-group">
										<input type="text" class="form-control" name="angkatan" value="{{old('angkatan', $data->angkatan)}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<label>Jurusan</label>
									<div class="form-group">
										<select name="jurusan" class="form-control">
											@foreach($jurusan as $jr)
											<option value="{{$jr->id}}" @if($jr->id == $data->jurusan_id) selected @endif>{{$jr->nama}}</option>	
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('css')
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