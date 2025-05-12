<?php

// Initialize variables
$search = $_GET['search'] ?? '';
$filterPrice = $_GET['filterPrice'] ?? 'all';
$sort = $_GET['sort'] ?? 'latest';


// Start building the query
$query = DB::table('tbstok')
    ->join('tbkategori', 'tbkategori.id', '=', 'tbstok.idkategori')
    ->where('tbkategori.id', $idkategori) // $idkategori is the idkategori to be displayed
    ->leftJoin('mutasi', 'mutasi.idstok', '=', 'tbstok.kode')
    ->select(
        'tbstok.*',
        'tbkategori.nama as namakategori',
        'mutasi.qty as barangtersedia',
        DB::raw('COALESCE(mutasi.harga_perbarang) as hargabarang')
    )
    ->whereIn('mutasi.id', function ($query) {
        $query->select(DB::raw('MAX(id)'))
            ->from('mutasi')
            ->groupBy('idstok')
            ->orderBy('mutasi.id', 'desc');
    });

// Apply price filter if needed
if (!empty($search)) {
    $query->where('tbstok.nama', 'like', '%' . $search . '%');
}

// Apply price filter if needed
if ($filterPrice == 'termurah') {
    $query->orderBy('hargabarang', 'asc');
} elseif ($filterPrice == 'termahal') {
    $query->orderBy('hargabarang', 'desc');
}

if ($sort == 'popularity') {
    $query->leftJoin('status_history', 'status_history.idstok', '=', 'tbstok.kode')
          ->selectRaw('status_history.qty as total_qty')

          ->orderBy('total_qty', 'desc');
} else {
    // Default sorting by tbstok.id descending
    $query->orderBy('tbstok.id', 'desc');
}

$rec = $query->get();

foreach ($rec as $item) {
    $barangKeluar = DB::table('mutasi')
        ->where('idstok', $item->kode)
        ->where('mk', 'K')
        ->sum('qty');

    $barangTersedia = $item->barangtersedia;
    $item->barangtersedia = $barangTersedia;
}
?>

<!-- HTML Code for Filter Form -->

@foreach($rec as $value)
<div class="col-lg-4 col-md-6 col-sm-12 pb-1">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <div class="card product-item border-0 mb-4">
        <div id="imageCarousel{{ $value->id }}" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach(explode(',', $value->foto) as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ url('path/produk/' . $image) }}" class="d-block w-100" alt="Image" style="max-width: 90%; max-height: 400px; object-fit: cover;">
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
            <h6>Barang tersedia = {{ $value->barangtersedia }}</h6><h6 class="text-muted ml-2"></h6>
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
