    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Akun</span>
                <div class="dropdown-divider"></div>
                <a href="{{route('logout')}}" class="dropdown-item">

                        <button type="submit" class="dropdown-item"><i class="fas fa-user mr-2"></i> Logout</button>

                </a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                role="button">
                <i class="fas fa-td-large"></i>
            </a>
        </li>
    </ul>
