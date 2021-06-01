@extends('layouts.template')

@section('title') Tambah Kategori Berita @endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark"><i class="fa fa-newspaper"></i> Tambah Kategori</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Tambah Kategori</a></li>
					<!-- <li class="breadcrumb-item active">Dashboard v1</li> -->
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
						<h2 class="card-title"><i class="fa fa-folder-plus"></i> Tambah Kategori Berita</h2>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					
					<div class="card-body">
						<form method="post" id="add-kategori">
							@csrf
							<label>Kategori Berita</label>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="masukkan kategori berita" name="nama">
							</div>
						</div>
						<div class="card-footer">
							<button type="reset" class="btn btn-default">Reset</button>
							<button type="submit" class="btn btn-primary float-right">Submit</button>
						</form>
					</div>
					
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-header card-secondary card-outline">
						<h2 class="card-title"><i class="fa fa-th-list"></i> Daftar Kategori Berita</h2>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus"></i>
							</button>
						</div>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="table-responsive-sm">
							<table id="tabel_kategori" class="table table-bordered" style="width:100% !important; ">
								<thead>
									<tr>
										<th>No.</th>
										<th>Nama Kategori Berita</th>
										<th>Action</th>
									</tr>
								</thead>  
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal Edit Kategori -->
<div class="modal fade bd-example-modal" id="modal-edit-kategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form method="post" id="edit-kategori">
			@csrf
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Kategori Berita </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<input type="hidden" name="hidden_id" id="edit-kategori-id">
					<div class="form-group">
						<label>Nama Kategori Berita</label>
						<input type="text" class="form-control" name="nama" id="nama-kategori">
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary btn-sm">Edit</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- End Modal Edit Kategori -->
@endsection

@section('js')
<script type="text/javascript">
	$('#modal-edit-kategori').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) 
		var id = button.data('id') 
		var nama = button.data('nama') 

		var modal = $(this)
		modal.find('.modal-body #edit-kategori-id').val(id)
		modal.find('.modal-body #nama-kategori').val(nama)
	})

	$('#edit-kategori').submit(function(e){ //edit kategori berita
		e.preventDefault();
		var request = new FormData(this);
		var endpoint= '{{route("edit.kategori.berita")}}';
		$.ajax({
			url: endpoint,
			method: "POST",
			data: request,
			contentType: false,
			cache: false,
			processData: false,
            // dataType: "json",
            success:function(data){
            	$('#edit-kategori')[0].reset();
            	$('#tabel_kategori').DataTable().ajax.reload();
            	$('#modal-edit-kategori').modal('hide');
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

	$('#add-kategori').submit(function(e){ // tambah kategori perusahaan
		e.preventDefault();

		var request = new FormData(this);
		var endpoint= '{{route("post.kategori.berita")}}';
		$.ajax({
			url: endpoint,
			method: "POST",
			data: request,
			contentType: false,
			cache: false,
			processData: false,
			success:function(data){
				$('#add-kategori')[0].reset();
				$('#tabel_kategori').DataTable().ajax.reload();
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
          	$('#tabel_kategori').DataTable().ajax.reload();
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

	kategori = $(document).ready(function(){
		$('#tabel_kategori').DataTable({
			"processing": true,
			"serverSide": true,
			"deferRender": true,
			"ordering": true,
			"order": [[ 0, 'desc' ]],
			"aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
			"ajax":  {
                "url":  '{{route("table.kategori.berita")}}', // URL file untuk proses select datanya
                "type": "GET"
            },
            "columns": [
            { data: 'DT_RowIndex', name:'DT_RowIndex'},
            { "data": "nama" },
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
</script>
@endsection