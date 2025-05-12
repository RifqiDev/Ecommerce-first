<?php

use Illuminate\Support\Facades\DB;

// Mengambil parameter dari request
$search = $_GET['search'] ?? '';
$filterPriceRadio = $_GET['filterPriceRadio'] ?? 'all';
$filterPriceCheckbox = $_GET['priceCheckbox'] ?? ['all'];
$sort = $_GET['sort'] ?? 'latest';

// Pastikan $filterPrice selalu berupa array
if (!is_array($filterPrice)) {
    $filterPrice = explode(',', $filterPrice);
}

// Mulai membangun query
$query = DB::table('tbstok')
    ->leftJoin('mutasi', 'mutasi.idstok', '=', 'tbstok.kode')
    ->leftJoin('status_history', 'status_history.idstok', '=', 'tbstok.kode')


    ->select(
        'tbstok.*',
        'mutasi.qty as barangtersedia',
        'status_history.qty as total_qty',

        DB::raw('COALESCE(mutasi.harga_perbarang) as hargabarang')
    )
    ->whereIn('mutasi.id', function ($query) {
        $query->select(DB::raw('MAX(id)'))
            ->from('mutasi')
            ->groupBy('idstok')
            ->orderBy('mutasi.id', 'desc');
    });

// Terapkan filter pencarian jika ada
if (!empty($search)) {
    $query->where('tbstok.nama', 'like', '%' . $search . '%');
}

if ($filterPriceRadio == 'termurah') {
    $query
            ->orderBy('hargabarang', 'asc');
} elseif ($filterPriceRadio == 'termahal') {
    $query
            ->orderBy('hargabarang', 'desc');
}

// Terapkan filter harga jika diperlukan
if (!in_array('all', $filterPriceCheckbox)) {
    $query->where(function ($query) use ($filterPriceCheckbox) {
        foreach ($filterPriceCheckbox as $range) {
            list($min, $max) = array_map('intval', explode('-', $range)); // Pastikan nilai diubah menjadi integer
            if ($min >= 0 && $max > 0) {
                $query->orWhereBetween('tbstok.hargajual', [$min, $max]);
            }
        }
    });
}

// Terapkan filter popularitas jika dipilih
if ($sort == 'popularity') {
    $query->orderBy('total_qty', 'desc');
} else {
    // Default sorting by tbstok.id descending
    $query->orderBy('tbstok.id', 'desc');
}

// Batasi hasil query ke 9 produk per halaman
$rec = $query->paginate(9);

// Lakukan loop untuk setiap item produk
foreach ($rec as $item) {
    $barangKeluar = DB::table('mutasi')
        ->where('idstok', $item->kode)
        ->where('mk', 'K')
        ->sum('qty');

    $barangTersedia = $item->barangtersedia;
    $item->barangtersedia = $barangTersedia;
}
?>

<!-- Tampilkan Produk -->
@foreach($rec as $value)
<div class="col-lg-4 col-md-6 col-sm-12 pb-1">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <div class="card product-item border-0 mb-4">
        <div id="imageCarousel{{ $value->id }}" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach(explode(',', $value->foto) as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <a href="{{ url('detail/'.$value->id) }}" ><img src="{{ url('path/produk/' . $image) }}" class="d-block w-100" alt="Image" style="max-width: 90%; max-height: 400px; object-fit: cover;"> </a>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#imageCarousel{{ $value->id }}" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#imageCarousel{{ $value->id }}" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3">{{ $value->nama }}</h6>
            <div class="d-flex justify-content-center">
                <h6>{{ number_format($value->hargabarang) }}</h6><h6 class="text-muted ml-2"></h6>
            </div>
            @if ($value->total_qty > 0)
            Barang Terjual = {{ $value->total_qty }}
        @else
            Barang belum terjual
        @endif

        @if ($value->barangtersedia )
        <h6>Barang tersedia = {{ $value->barangtersedia }}</h6><h6 class="text-muted ml-2"></h6>
        @else
        <h6>Barang Tidak tersedia</h6><h6 class="text-muted ml-2"></h6>
        @endif

        </div>
        <div class="card-footer d-flex justify-content-between bg-light border">
            <a href="{{ url('detail/'.$value->id) }}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
            <form action="{{ route('cart.add', ['productId' => $value->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</button>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Tampilkan Link Pagination -->
<div class="col-12 pb-1">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-3">
            <!-- Custom Pagination Links -->
            @if ($rec->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $rec->appends(request()->except('page'))->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            @foreach ($rec->getUrlRange(1, $rec->lastPage()) as $page => $url)
                @if ($page == $rec->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $rec->appends(request()->except('page'))->url($page) }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($rec->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $rec->appends(request()->except('page'))->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>
</div>
