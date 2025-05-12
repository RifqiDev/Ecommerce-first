<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class kategori extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kategori.tbkategori')
        ->with('judul', 'Daftar Kategori')
        ->with('nama', 'Kategori');
      }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.input')
        ->with('judul', 'Daftar Kategori')
        ->with('nama', 'Kategori');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $foto = $r->file('foto');
        if ($foto) {
            $nama_file = time() . "_" . $foto->getClientOriginalName(); // Generate nama file unik
            $tujuan_upload = 'path/produk/'; // Tentukan direktori tujuan untuk menyimpan file foto

            $foto->move($tujuan_upload, $nama_file); // Simpan file foto ke direktori
        } else {
            $nama_file = null; // Set nama file menjadi null jika file foto tidak diunggah
        }
        $x=array(
            'id'=> $r->id,
            'nama'=> $r->nama,
            'foto' => $nama_file, // Simpan nama file foto

        );
        DB::table('tbkategori')->insertgetId($x);
        return view('kategori.tbkategori')
        ->with('judul', 'Daftar Kategori')
        ->with('nama', 'Kategori');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('kategori.edit')
        ->with('judul', 'Daftar Kategori')
        ->with('nama', 'Kategori')
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
        $foto = $r->file('foto');
        if ($foto) {
            $nama_file = time() . "_" . $foto->getClientOriginalName(); // Generate nama file unik
            $tujuan_upload = 'path/produk/'; // Tentukan direktori tujuan untuk menyimpan file foto

            $foto->move($tujuan_upload, $nama_file); // Simpan file foto ke direktori
        }
        $x=array(
            'id'=> $r->id,
            'nama'=> $r->nama,
            'foto' => $nama_file, // Simpan nama file foto

        );

        DB::table('tbkategori')
        ->where('id', $id)
        ->update($x);
        return view('kategori.tbkategori')
        ->with('judul', 'Daftar Kategori')
        ->with('nama', 'Kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbkategori')->where('id', $id)->delete();
        return view('kategori.tbkategori')
        ->with('judul', 'Daftar Kategori')
        ->with('nama', 'Kategori');
    }
}
