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
              <li class="breadcrumb-item"><a href="{{ url('/mutasi/create') }}">Tambah {{ $nama }}</a></li>
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
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor Bukti</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $rec = DB::table('mutasi')
                            ->leftJoin('tbstok', 'tbstok.kode', '=', 'mutasi.idstok')
                            ->select(
                                'mutasi.*',
                                'tbstok.nama as namabarang'
                            )
                            ->get();
                        $Nobukti = null;
                        $Namabarang = null;
                        ?>
                    @php
                    $displayedNobukti = []; // Array untuk melacak nomor bukti yang sudah ditampilkan
                    @endphp

                    @foreach ($rec as $key => $value)
                        @if (in_array($value->nobukti, $displayedNobukti))
                            @continue
                        @endif

                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                {{ $value->date }}
                            </td>
                            <td>
                                {{ $value->nobukti }}
                            </td>

                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal{{ $value->nobukti }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <!-- pop up edit -->
                                <div class="modal fade" id="editModal{{ $value->nobukti }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $value->nobukti }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $value->nobukti }}">Detail Pesanan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label>Nomor Bukti = {{ $value->nobukti }}</label><br>
                                                <hr>
                                                <h5>Detail Produk</h5><br>
                                                @foreach ($rec as $item)
                                                    @if ($item->nobukti == $value->nobukti)
                                                        <div class="form-group">
                                                            <label>Nama Produk: {{ $item->namabarang }}</label><br>
                                                            <label>QTY: {{ $item->qty }}</label><br>
                                                            <label>Harga Barang: {{ $item->harga_perbarang }}</label><br>
                                                            <label>Subtotal: {{ $item->harga_perbarang * $item->qty }}</label><br>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @php
                        $displayedNobukti[] = $value->nobukti; // Tambahkan nomor bukti ke array yang sudah ditampilkan
                        @endphp
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
