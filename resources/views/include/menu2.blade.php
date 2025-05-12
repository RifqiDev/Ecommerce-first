<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    <?php
                    $variable= DB::table('tbkategori')->get();
                    foreach ($variable as $key ) { ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">{{$key->nama}} <i class="fa fa-angle-down float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                <?php
                                $variable2=DB::table('tbstok')
                                ->where('tbstok.idkategori',$key->id)
                                ->get();
                                foreach ($variable2 as $key2 ) {?>
                                    <a href="{{ url('detail/'.$key2->id)}}" class="dropdown-item">{{ $key2->nama }}</a>
                                <?php }?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ url('index') }}" class="nav-item nav-link">Home</a>
                        <a href="{{ url('shop') }}" class="nav-item nav-link active">Shop</a>
                        <a href="detail.html" class="nav-item nav-link">Shop Detail</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="{{ url('cart') }}" class="dropdown-item">Shopping Cart</a>
                                <a href="{{ url('checkout') }}" class="dropdown-item">Checkout</a>
                            </div>
                        </div>
                        <a href="{{ url('contact') }}" class="nav-item nav-link">Contact</a>
                    </div>

                    <div class="navbar-nav ml-auto py-0">
                        @if (Auth::guest())
                        <a href="{{ url('/login') }}" class="nav-item nav-link">Login</a>
                        <a href="{{ url('/register') }}" class="nav-item nav-link">Register</a>
                        @endif
                        @if (Auth::check())
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

                @endif
                    </div>


<!-- Setelah login -->

                </div>
            </nav>
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php $rec=DB::table('tbstok')->where('pajang', 1)->get(); ?>
                    @foreach($rec as $key => $value)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}"style="height: 410px;">
                            @foreach(explode(',', $value->foto) as $index => $image)
                                @if($index === 2)
                                    <img src="{{ url('path/produk/' . $image) }}" class="d-block w-100" alt="Image">
                                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">{{ $value->nama }}</h3>
                                    <a href="{{ url('detail/'.$value->id) }}" class="btn btn-light py-2 px-3">Shop Now</a>
                                </div>
                            </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>
            <

                    <!-- else -->

            </div>
        </div>
    </div>
</div>
