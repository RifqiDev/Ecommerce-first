<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Detail extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('detail');
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
        $rec = DB::table('tbstok')
    ->leftJoin('mutasi', 'mutasi.idstok', '=', 'tbstok.kode')
    ->select(
        'tbstok.*',
        'mutasi.qty as barangtersedia',
        DB::raw('COALESCE(mutasi.harga_perbarang, mutasi.harga_barang) as hargabarang')
    )
    ->whereIn('mutasi.id', function ($query) {
        $query->select(DB::raw('MAX(id)'))
            ->from('mutasi')
            ->groupBy('idstok')
            ->orderBy('mutasi.id', 'desc');
    })
    ->where('tbstok.id', $id)  // Menjelaskan asal kolom id
    ->first();

if ($rec) {
    // Menghitung jumlah barang keluar (qty dengan mk = 'K')
    $barangKeluar = DB::table('mutasi')
        ->where('idstok', $rec->kode)
        ->where('mk', 'K')
        ->sum('qty');

    // Menghitung jumlah barang tersedia
    $barangTersedia = $rec->barangtersedia;

    // Menggunakan nilai barang tersedia untuk item ini
    $rec->barangtersedia = $barangTersedia;
}
        return view('detail' , compact('rec'))

        ->with('id',$id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $r, string $id)


    {
        $foto = $r->file('foto'); // Ambil file foto dari request
        $nama_file = time() . "_" . $foto->getClientOriginalName(); // Generate nama file unik
        $tujuan_upload = 'path/'; // Tentukan direktori tujuan untuk menyimpan file foto

        $foto->move($tujuan_upload, $nama_file); // Simpan file foto ke direktori

        $x=array(
        'id' => $r->id,
        'kode' => $r->kode,
        'nama' => $r->nama,
        'idsatuan' => $r->idsatuan,
        'idkategori' => $r->idkategori,
        'saldoawal' => $r->saldoawal,
        'hargajual' => $r->hargajual,
        'tglexp' => $r->tglexp,
        'hargamodal' => $r->hargamodal,
        'foto' => $nama_file, // Simpan nama file foto
        'desc' => $r->desc,
        'pajang' => $r->panjang,
        'saldoakhir' => $r->saldoakhir,
    );
    DB::table('tbstok')
    ->where('id',$r->id);
        return view('shop');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
