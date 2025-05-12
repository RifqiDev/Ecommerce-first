<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('homelte') }}" class="brand-link">
        <img src="{{ url('lte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Aplikasi E-com</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (isset($user))
                    <img src="{{ asset('storage/image-user1/' . $user->image) }}" class="img-circle elevation-2"
                        alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> {{ $user->name }}</a>
                @endif
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="{{ url('homelte') }}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Menu E-com
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('stok') }}" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Menu Stok
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pelanggan') }}" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Menu Pelanggan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pemasok') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu Pemasok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('kategori') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('satuan') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu Satuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('users') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('mutasi') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu Mutasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('status') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Menu Status</p>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
