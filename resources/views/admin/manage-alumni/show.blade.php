 @extends('layouts.template')

 @section('title') 
 Show Alumni
 @endsection


 @section('css')
 <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">

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

/* .bg-danger {
 	color: #721c24;
 	background-color: #f8d7da !important;
 	border-color: #f5c6cb;
 	}*/

 	.alert-anchor {
 		color: blue !important;
 	}
 </style>
 @endsection

 @section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
 	<div class="container-fluid">
 	</div>
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <section class="content">
 	<div class="container-fluid">
 		<div class="row">

 			<div class="col-12">
 				@if(session('success'))
 				<div class="alert alert-success alert-dismissible fade show" role="alert">
 					<strong>Berhasil Mengubah Data !</strong>
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
 					<strong>Whoops!</strong>
 					<ul>
 						@foreach ($errors->all() as $error)
 						<li>{{ $error }}</li>
 						@endforeach
 					</ul>

 				</div>
 				@endif
 				<div class="invoice p-3 mb-3">
 					<!-- title row -->
 					<div class="row">
 						<div class="col-12">
 							<h4>
 								<i class="fas fa-user"></i> Detail Alumni
 								@if($data->is_active == '0')
 								<button type="button" class="btn btn-primary btn-sm float-right" style="margin-right: 5px;" onclick="konfir()"  id="konfir" href="{{route('alumni.konfirmasi', ['id' => $data->id])}}">
 									<i class="fas fa-check"></i> Konfirmasi Alumni
 								</button>
 								<button type="button" class="btn btn-danger	 btn-sm float-right" style="margin-right: 5px;" data-toggle="modal" data-target="#modal-tolak-alumni">
 									<i class="fas fa-times"></i> Bukan Alumni
 								</button>
                <button type="button" class="btn btn-secondary btn-sm float-right" style="margin-right: 5px;" onclick="cek()"  id="cek" href="{{route('cek.alumni', ['id' => $data->id])}}">
                  <i class="fas fa-clipboard-check"></i> Cek Alumni
                </button>
                @elseif($data->is_active == '1')
                <span class="badge badge-success"><i class="fas fa-check"></i> Alumni</span>
                @elseif($data->is_active == 'tolak')
                <span class="badge badge-danger"><i class="fas fa-times"></i> Ditolak</span>
                @endif
              </h4>

            </div>
            <!-- /.col -->
          </div>
          <br>
          <div class="row invoice-info">
           <div class="col-sm-6 invoice-col">
            Data Pribadi
            <address>
             <strong>{{$data->name}}</strong><br>
             {{$data->stb}} - {{$data->angkatan}} <br>
             {{$data->jurusan->nama}} <br>
             {{$data->alamat}} <br>
             {{$data->alamat_pribadi->tipe}} {{$data->alamat_pribadi->nama_kota}}, Provinsi {{$data->alamat_pribadi->provinsi->nama_provinsi}}<br>
             No Hp: {{$data->nohp}}<br>
             Email: {{$data->email}}
           </address>
         </div>
         @if(!is_null($data->perusahaan))
         <div class="col-sm-6 invoice-col">
          Pekerjaan
          <address>
           <strong>{{$data->kategori->nama}}</strong><br>
           {{$data->jabatan}}<br>
           {{$data->perusahaan}}<br>
           {{$data->alamat_perusahaan}}
         </address>
       </div>
       @endif
     </div>

     @if(! $wirausaha->isEmpty())
     <h4>Wirausaha</h4>
     <div class="row">
       <div class="col-12 table-responsive">
        <table class="table">
         <thead>
          <tr>
           <th>No</th>
           <th>Nama</th>
           <th>Kategori</th>
           <th>Alamat</th>
           <th>Lokasi</th>
         </tr>
       </thead>
       <tbody>
        @php $no = 1; @endphp
        @foreach($wirausaha as $wrs)
        <tr>
         <td>{{$no++}}</td>
         <td>{{$wrs->nama}}</td>
         <td>{{$wrs->kategori->nama}}</td>
         <td>{{$wrs->alamat->tipe}} {{$wrs->alamat->nama_kota}}, Provinsi {{$wrs->alamat->provinsi->nama_provinsi}}</td>
         <td>{{$wrs->lokasi}}</td>
       </tr>
       @endforeach
     </tbody>
   </table>
 </div>
</div>
</div>
@endif
<!-- /.invoice -->
</div>
</div>
</div><!-- /.container-fluid -->
</section>


@if($data->is_active == '0')
<!-- Modal Tolak Alumni -->
<div class="modal fade bd-example-modal" id="modal-tolak-alumni" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
   <form method="post" action="{{route('alumni.tolak', ['id' => $data->id])}}">
    @csrf
    {{ method_field('PUT') }}
    <div class="modal-content">
     <div class="modal-header ">
      <h5 class="modal-title">Tolak Alumni</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>

   <div class="modal-body">
    <div class="form-group">
     <label>Pesan : </label>
     <textarea class="form-control" rows="4" name="pesan"></textarea>
   </div>
 </div>

 <div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Tutup</button>
  <button type="submit" class="btn btn-outline-primary btn-sm">Tolak Alumni</button>
</div>
</div>
</form>
</div>
</div>
<!-- End Modal Tolak Alumni -->

<!-- Modal Validity -->
<div class="modal fade bd-example-modal" id="modal-validity" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Data Alumni Serupa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p id="pesan"></p>
        <table id="table">
          <tr>
            <td>STB </td>
            <td> : </td>
            <td id="stb"></td>
          </tr>
          <tr>
            <td>Nama </td>
            <td> : </td>
            <td id="nama"></td>
          </tr>
          <tr>
            <td>Angkatan </td>
            <td> : </td>
            <td id="angkatan"></td>
          </tr>
          <tr>
            <td>Jurusan </td>
            <td> : </td>
            <td id="jurusan"></td>
          </tr>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Edit Kategori -->
@section('js')
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
  function konfir() { // menghapus jurusan
    $(document).on('click', '#konfir', function(){
      Swal.fire({
        title: 'konfirmasi Alumni',
        text: "Periksa dengan sebaik mungkin sebelum konfirmasi, status alumni tidak dapat dikembalikan",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Lanjutkan!',
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
              '_method' : 'PUT',
              '_token'  : token
            },
            success:function(data){
              if(data.status == 'success') {
                successToRelaoad(data.status, data.pesan);
              } else {
                berhasil(data.status, data.pesan);
              }
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

  function cek() { // cek validity alumni
    $(document).on('click', '#cek', function(){
      Swal.fire({
        title: 'Cek Validity Alumni',
        text: "Akan memeriksa apakah ada data Alumni yang sesuai",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Lanjutkan!',
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
              '_method' : 'PUT',
              '_token'  : token
            },
            success:function(data){
              if(data.status == 'success') {
                // berhasil(data.status, data.pesan);
                $('#pesan').html("<b class='text-success'>"+data.pesan+"</b>");
                $('#stb').html("<b>"+data.data.stb+"</b>");
                $('#nama').html("<b>"+data.data.name+"</b>");
                $('#angkatan').html("<b>"+data.data.angkatan+"</b>");
                $('#jurusan').html("<b>"+data.data.jurusan.nama+"</b>");             
                $("#modal-validity").modal("show");
              } else {
                $('#table').html('');
                $('#pesan').html("<b class='text-danger'>"+data.pesan+"</b>");
                $("#modal-validity").modal("show");
              }
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


  function successToRelaoad(status, pesan) {
    Swal.fire({
      type: status,
      title: pesan,
      showConfirmButton: true,
      button: "Ok"
    }).then((result) => {
      location.reload();
    })
  }

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


@endif
@endsection