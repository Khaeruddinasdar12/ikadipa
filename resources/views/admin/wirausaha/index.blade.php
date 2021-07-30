@extends('layouts.template')

@section('title')
Wirausaha
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('datatables.min.css')}}"/>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
</div>
<!-- /.content-header -->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><i class="fa fa-briefcase"></i> Wirausaha</h2>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<table id="tabel_berita" class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama Wirausaha</th>
									<th>Kategori</th>
									<th>Alamat</th>
									<th>Pemilik</th>
									<th>Action</th>
								</tr>
							</thead>  
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->

@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script type="text/javascript">

		tabel = $(document).ready(function(){
			$('#tabel_berita').DataTable({
				"processing": true,
				"serverSide": true,
				"deferRender": true,
				"ordering": true,
				"order": [[ 0, 'desc' ]],
				"aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
				"ajax": {
                "url":  '{{route("table.wirausaha")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "nama" },
              { "data": "kategori.nama" },
              { "data": "alamat" },
              { "data": "user.name" },
              { "data": "action" },
              ]
            });
		});

	</script>
	@endsection