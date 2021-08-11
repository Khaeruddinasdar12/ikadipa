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
</div>
<!-- /.content-header -->
<section class="content">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h2 class="card-title"><i class="fa fa-newspaper"></i> List Alumni</h2>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<table id="tabel_alumni" class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>STB</th>
									<th>Nama</th>
									<th>Email</th>
									<th>No HP</th>
									<th>Jurusan</th>
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


<!-- Modal Detail Alumni -->
<div class="modal fade bd-example-modal" id="modal-detail-alumni" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-info"></i> Detail Alumni </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<p><strong>STB : </strong> </p>
					<p><strong>Nama : </strong> </p>
					<p><strong>Email : </strong> </p>
					<p><strong>No HP : </strong> </p>
					<p><strong>Jurusan : </strong> </p>
					<p><strong>Alamat : </strong> </p>
					<p><strong>Pekerjaan : </strong> </p>
					<p><strong>Jabatan : </strong> </p>
					<p><strong>Alamat Pekerjaan : </strong> </p>
					<p><strong>Nama : </strong> </p>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary btn-sm">Edit</button>
				</div>
			</div>
	</div>
</div>
<!-- End Modal Detail Alumni Kategori -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">

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
								$('#tabel_berita').DataTable().ajax.reload();
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
			$('#tabel_alumni').DataTable({
				"processing": true,
				"serverSide": true,
				"deferRender": true,
				"ordering": true,
				"order": [[ 0, 'desc' ]],
				"aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
				"ajax": {
                "url":  '{{route("table.alumni")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "stb" },
              { "data": "name" },
              { "data": "email" },
              { "data": "nohp" },
              { "data": "jurusan.nama" },
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