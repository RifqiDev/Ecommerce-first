<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
        {
            return view('mutasi.tbmutasi')
            ->with('judul', 'Daftar Beli')
            ->with('nama', 'Beli');
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view('mutasi.input')
            ->with('judul', 'Daftar Beli')
            ->with('nama', 'Beli');
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $r)
        {

            $nobukti = 'm' . date('YmdHis') ;
            $idstoks = $r->idstok;
            $qtys = $r->qty;
            $mks = $r->mk;
            $hargaBelis = $r->harga_beli;
            $markups = $r->markup;

            DB::transaction(function () use ($nobukti, $idstoks, $qtys, $mks, $hargaBelis, $markups) {
                foreach ($idstoks as $key => $idstok) {
                    $rec = DB::table('mutasi')
                        ->select('mutasi.*', 'mutasi.qty as barangtersedia')
                        ->where('idstok', $idstok)
                        ->orderBy('id', 'desc')
                        ->first();

                    $barangTersedia = 0;
                    $totalHargaJual = 0;
                    $totalHargaPerBarang = 0;

                    if ($rec) {
                        $barangTersedia = $rec->barangtersedia + $qtys[$key];
                        $totalHargaJual = ($rec->harga_beli * (1 + $rec->markup)) + $rec->total_harga_jual;
                        $totalHargaPerBarang = $totalHargaJual / $barangTersedia;
                    } else {
                        $barangTersedia = $qtys[$key];
                        $totalHargaJual = ($hargaBelis[$key] * (1 + $markups[$key]));
                        $totalHargaPerBarang = $totalHargaJual / $barangTersedia;
                    }

                    $beliData = [
                        'nobukti' => $nobukti, // Menggunakan No Bukti tunggal
                        'idstok' => $idstok,
                        'qty' => $qtys[$key],
                        'mk' => $mks[$key],
                        'harga_beli' => $hargaBelis[$key],
                        'markup' => $markups[$key],
                        'saldo' => $barangTersedia,
                        'hargajual' => $totalHargaJual,
                        'hargaperbarang' => $totalHargaPerBarang,
                    ];

                    $mutasiData = [
                        'nobukti' => $nobukti, // Menggunakan No Bukti tunggal
                        'idstok' => $idstok,
                        'qty' => $barangTersedia,
                        'mk' => $mks[$key],
                        'harga_beli' => $hargaBelis[$key],
                        'markup' => $markups[$key],
                        'total_harga_jual' => $totalHargaJual,
                        'harga_perbarang' => $totalHargaPerBarang,
                    ];



                    if ($rec == null) {
                        DB::table('beli')->insert($beliData);
                        DB::table('mutasi')->insert($mutasiData);
                    } else {
                        $pesan = "Nama Sudah Terdaftar";
                    }

                }
            });


            return view('mutasi.tbmutasi')
                ->with('judul', 'Daftar Beli')
                ->with('nama', 'Beli');
        }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('mutasi.edit')
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
