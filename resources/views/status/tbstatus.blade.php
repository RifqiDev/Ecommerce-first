<!DOCTYPE html>
<html>
<head>
    @include('include.head')

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    @include('include.akun')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
  @include('include.menu')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $judul }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Data </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">



            <div class="card">

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>qty</th>
                        <th>Nama User</th>
                        <th>Status</th>
                        <th>Harga Barang</th>
                        <th>Total Harga</th>
                        <th>Keterangan</th>
                        <th>No Bukti</th>
                        <th>MK</th>
                        <th>Date</th>
                        <th>Foto</th>
                        <th>EDIT</th>
                        <th>DELETE</th>


                    </thead>
                    <?php
                    $rec=DB::table('status')
                    ->leftJoin('tbstok','tbstok.kode','=', 'status.product_id')
                    ->leftJoin('users','users.id','=', 'status.user_id')
                        ->select(
                             'status.*',
                            'tbstok.nama as namaproduk',
                            'users.name as namauser',
                        )
                        ->get();
                    ?>
                     @foreach ( $rec as $value )
                    <tr>

                        <th>{{ $value -> id  }}</th>
                        <th>{{ $value -> namaproduk  }}</th>
                        <th>{{ $value -> qty  }}</th>
                        <th>{{ $value -> namauser  }}</th>
                        <th>{{ $value -> status  }}</th>
                        <th>{{ $value -> harga_barang  }}</th>
                        <th>{{ $value -> total_harga  }}</th>
                        <th>{{ $value -> ket  }}</th>
                        <th>{{ $value -> nobukti  }}</th>
                        <th>{{ $value -> mk  }}</th>
                        <th>{{ $value -> date  }}</th>
                        <th> @foreach(explode(',', $value->foto) as $image)
                            <img src="{{ url('path/status/' . $image) }}" alt="" style="max-width: 70%;">
                        @endforeach</th>



                        <th><a href="{{ url ('status/'.$value->id) }}"> Verifikasi </th>
                        <th><form action="{{ route('status.destroy', $value->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                        </form>    </th>




                    </tr>
                    @endforeach



                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
@include('include.bawah')
</body>
</html>
