@extends('layouts.template')

@section('title')
List Donasi
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
					<h2 class="card-title"><i class="fa fa-newspaper"></i> List Donasi</h2>
					<a href="{{route('donasi.create')}}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"> Tambah Donasi</i></a>
				</div>
				<div class="card-body">
					<div class="table-responsive-sm">
						<table id="tabel_donasi" class="table table-bordered" style="width:100% !important; ">
							<thead>
								<tr>
									<th>No.</th>
									<th>Judul Donasi</th>
									<!-- <th>Gambar</th> -->
									<th>Batas Akhir Donasi</th>
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

<!-- Modal Detail Donasi -->
<div class="modal fade bd-example-modal-lg" id="modal-detail-donasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="fa fa-calendar-week"></i> Detail Event </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<h4 id="nama">Nama Event atau judul event segera</h4>
						<hr>
						<p id="date_end">Berakhir pada : </p>
						<img src="{{asset('picture.png')}}" class="img-fluid mx-auto d-block" width="100px" height="100px" id="gambar">
						<p align="justify" id="deskripsi"></p>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
</div>
<!-- End Modal Detail Donasi -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">

	$('#modal-detail-donasi').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) 
		var id = button.data('id') 
		var nama = button.data('nama') 
		var date_end = button.data('date_end') 
		var gambar = button.data('gambar')
		var deskripsi = button.data('deskripsi') 
		var gbr = '{{ URL::asset("storage")}}/'+gambar

		var modal = $(this)
		// modal.find('.modal-body #edit-jurusan-id').val(id)
		modal.find('.modal-body #nama').html(nama)
		modal.find('.modal-body #date_end').html('Berakhir pada : <strong class="text-danger">'+date_end+'</strong>')
		modal.find('.modal-body #deskripsi').html(deskripsi)
		modal.find('.modal-body #gambar').attr('src', gbr)
	})

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
								$('#tabel_donasi').DataTable().ajax.reload();
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
			$('#tabel_donasi').DataTable({
				"processing": true,
				"serverSide": true,
				"deferRender": true,
				"ordering": true,
				"order": [[ 0, 'desc' ]],
				"aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
				"ajax": {
                "url":  '{{route("table.donasi")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "nama" },
              { "data": "date_end" },
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