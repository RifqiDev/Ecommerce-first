<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

class Status extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('status.tbstatus')
        ->with('judul', 'Status Barang Pesan User')
        ->with('nama', 'Status');
        ;
        ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            return view('status.edit')
        ->with('judul', ' Status')
        ->with('nama', 'Status')
        ->with('id',$id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)
{
    // Retrieve the latest record from the 'status' table

$rec = DB::table('status')
    ->leftJoin('mutasi', 'mutasi.idstok', '=', 'status.product_id')
    ->select('status.*', 'mutasi.qty  as barangtersedia',
    'mutasi.total_harga_jual as saldoakhir',
    'mutasi.harga_beli as hargabeli',
    'mutasi.markup as mark',
    'mutasi.harga_perbarang as hargaperbarang')

    ->where('product_id', $r->product_id)
    ->orderBy('mutasi.id', 'desc')
    ->first();

$rec2 = DB::table('status_history')
    ->where('idstok', $r->product_id)
    ->orderBy('status_history.id', 'desc')
    ->first();

// Initialize variables
$barangKeluar = 0;
$hargabarangsisa = 0;

if ($rec) {
    // Calculate remaining stock and price
    $barangKeluar = $rec->barangtersedia - $r->qty;
    $hargabarangsisa = $rec->saldoakhir - $r->total_harga;
}

if ($rec2) {
    $barangpopuler = $rec2->qty + $r->qty;
} else {
    $barangpopuler = $r->qty;
}

// Prepare data for 'jual' table insertion
$jualData = [
    'user_id' => $r->user_id,
    'harga_beli' => $rec->hargabeli,
    'markup' => $rec->mark,
    'harga_perbarang' => $rec->hargaperbarang,
    'nobukti' => $rec->nobukti,
    'idstok' => $r->product_id,
    'qty' => $barangKeluar,
    'mk' => $r->input('mk', 'k'),
    'ket' => $r->ket,
    'total_harga_jual' => $hargabarangsisa,
];

$history = [
    'user_id' => $r->user_id,
    'harga_barang' => $rec->hargaperbarang,
    'nobukti' => $rec->nobukti,
    'idstok' => $r->product_id,
    'qty' => $barangpopuler,
    'mk' => $r->input('mk', 'k'),
    'ket' => $r->ket,
    'total_harga' => $r->total_harga,
];

// Perform database operations within a transaction
DB::transaction(function () use ($jualData, $history, $r,$id) {
    // Delete existing entries in 'status_history' for the given product
    DB::table('status_history')->where('idstok', $r->product_id)->delete();

    // Insert into 'mutasi' table and get the ID
    DB::table('mutasi')->insertGetId($jualData);

    // Insert into 'status_history' table
    DB::table('status_history')->insertGetId($history);


        DB::table('status')->where('id', $id)->delete();
});


    // Return the view with status data
    return view('status.tbstatus')
        ->with('judul', 'Daftar Status')
        ->with('nama', 'Status');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('status')->where('id', $id)->delete();
        return view('status.tbstatus')
        ->with('judul', 'Status Barang')
        ->with('nama', 'Status');
    }
}
