<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('app.name')}} | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset('admins/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <!-- <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"> -->
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('admins/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('admins/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admins/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('admins/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('admins/plugins/summernote/summernote-bs4.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
  <!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>

      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="">
                <span class="fas fa-user"></span> Profile
              </a>
              <a class="dropdown-item" href="{{ route('admin.logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              <span class="fas fa-sign-out-alt"></span> {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('admins/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
      <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('admins/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <li class="nav-item {{ request()->is('admin/pesanan') || request()->is('admin/riwayat-pesanan') ? 'has-treeview menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/pesanan') || request()->is('admin/riwayat-pesanan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>
                Data Pesanan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="" class="nav-link  {{ request()->is('admin/pesanan') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pesanan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link  {{ request()->is('admin/riwayat-pesanan') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Riwayat Pesanan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link {{ request()->is('admin/laporan-harian') || request()->is('admin/laporan-harian/*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Laporan Harian
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link {{ request()->is('admin/laporan-panen') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Laporan Panen
              </p>
            </a>
          </li>

          <li class="nav-item {{ request()->is('admin/berita/*')  ? 'has-treeview menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/berita/*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Berita
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('berita.kategori')}}" class="nav-link  {{ request()->is('admin/berita/tambah-kategori') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tambah Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link  {{ request()->is('admin/berita/daftar-berita') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Berita</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ request()->is('admin/manage-obat') || request()->is('admin/manage-pakan') ? 'has-treeview menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('admin/manage-obat') || request()->is('admin/manage-pakan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Product
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="" class="nav-link  {{ request()->is('admin/manage-obat') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Obat</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="" class="nav-link  {{ request()->is('admin/manage-pakan') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pakan</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">Manage Users</li>
          <li class="nav-item">
            <a href="" class="nav-link {{ request()->is('admin/manage-peternak') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Manage Peternak
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link {{ request()->is('admin/manage-pengecer') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Manage Pengecer
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('admin.setting')}}" class="nav-link {{ request()->is('admin/setting') ? 'active' : '' }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Setting
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

   @yield('content')
 </div>
 <!-- /.content-wrapper -->
 <footer class="main-footer">
  <strong>Copyright &copy; 2021 <a href="#">{{config('app.name')}}</a>.</strong>
  All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('admins/plugins/jquery/jquery.min.js') }}"></script>
@yield('js')

<!-- Bootstrap 4 -->
<script src="{{ asset('admins/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


<link rel="stylesheet" type="text/css" href="{{asset('datatables.min.css')}}"/>

<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admins/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('admins/dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ asset('admin/dist/js/demo.js') }}"></script> -->
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

<script>
  function gagal(key, pesan) {
    Swal.fire({
      type: 'error',
      title:  key + ' : ' + pesan,
      showConfirmButton: true,
      timer: 25500,
      button: "Ok"
    })
  }

  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
    });
  });
</script> 
</body>
</html>
