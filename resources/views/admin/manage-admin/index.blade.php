@extends('layouts.template')

@section('title')
Manage Admin
@endsection

@section('css')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
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
					<h2 class="card-title"><i class="fa fa-newspaper"></i> Manage Admin</h2>
					<a href="" class="btn btn-primary btn-sm float-right" data-target="#modal-tambah-admin" data-toggle="modal"><i class="fa fa-plus"> Tambah Admin</i></a>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<table id="tabel_admin" class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>Nama</th>
									<th>Email</th>
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


<!-- Modal Tambah Promo -->
<div class="modal fade bd-example-modal" id="modal-tambah-promo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form method="post" id="add-admin">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"> Tambah Admin</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Lengkap</label>
						<input type="text" class="form-control" name="name">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="email">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="text" class="form-control" name="password">
					</div>
					<div class="form-group">
						<label>Konfirmasi Password</label>
						<input type="text" class="form-control" name="password_confirmation">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary btn-sm">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End Modal Tambah Promo -->

<!-- Modal Edit Promo -->
<div class="modal fade bd-example-modal" id="modal-edit-promo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form method="post" id="add-promo">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Promo </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Promo</label>
						<input type="text" class="form-control" name="nama" id="nama">
					</div>
					<div class="form-group">
						<label>Url</label>
						<input type="text" class="form-control" name="url" id="url">
					</div>
					<div class="form-group">
						<label for="exampleFormControlFile1">Gambar</label>
						<input type="file" class="form-control-file" id="exampleFormControlFile1" onchange="tampilkanPreview(this,'preview')" accept="image/*" name="gambar" required>
					</div>
					<div class="form-group">
						<img id="preview" src="" width="90px" height="90px">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary btn-sm">Update</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End Modal Edit Promo -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
	
	$('#modal-edit-promo').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) 
		var id = button.data('id') 
		var nama = button.data('nama') 
		var kode = button.data('kode') 

		var modal = $(this)
		modal.find('.modal-body #edit-jurusan-id').val(id)
		modal.find('.modal-body #nama-jurusan').val(nama)
		modal.find('.modal-body #kode-jurusan').val(kode)
	})

		$('#add-admin').submit(function(e){ // tambah promo
			e.preventDefault();
			var request = new FormData(this);
			var endpoint= '{{route("manageadmin.store")}}';
			$.ajax({
				url: endpoint,
				method: "POST",
				data: request,
				contentType: false,
				cache: false,
				processData: false,
				success:function(data){
					$('#add-admin')[0].reset();
					$('#modal-tambah-admin').hide();
					$('#tabel_admin').DataTable().ajax.reload();
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
								$('#tabel_promo').DataTable().ajax.reload();
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

		tabel = $(document).ready(function(){
			$('#tabel_admin').DataTable({
				"processing": true,
				"serverSide": true,
				"deferRender": true,
				"ordering": true,
				"order": [[ 0, 'desc' ]],
				"aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
				"ajax": {
                "url":  '{{route("table.manageadmin")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "name" },
              { "data": "email" },
              { "data": "action" },
              ]
            });
		});

		function berhasil(status, pesan) {
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