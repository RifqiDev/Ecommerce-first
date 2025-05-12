<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class Controllerstok extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('stok.tbstok')
        ->with('judul', 'Daftar Stok')
        ->with('nama', 'Stok');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stok.input')
        ->with('judul', 'Input Stok')
        ->with('nama', 'Stok');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {


        $r->validate([
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Batasan untuk jenis dan ukuran file
        ]);

        $nama_file = [];
        foreach ($r->file('foto') as $image) {
            $nama_file[] = time() . '_' . $image->getClientOriginalName(); // Menambahkan nama file ke dalam array $nama_file
            $image->move(public_path('path/produk1'), end($nama_file)); // Menggunakan end() untuk mendapatkan elemen terakhir dari array
        }

        $x = [
            'id' => $r->id,
            'kode' => $r->kode,
            'nama' => $r->nama,
            'idsatuan' => $r->idsatuan,
            'idkategori' => $r->idkategori,
            'tglexp' => $r->tglexp,
            'foto' => implode(',', $nama_file), // Simpan nama file foto
            'desc' => $r->desc,
            'pajang' => $r->pajang,
        ];

        DB::table('tbstok')->insert($x); // Simpan data ke database

        return view('stok.tbstok')
            ->with('judul', 'Daftar Stok')
            ->with('nama', 'Stok');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('stok.edit')
        ->with('judul', 'Edit Stok')
        ->with('nama', 'Stok')
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



            $rec = DB::table('tbstok')
            ->where('id', $id)
            ->first();


            $r->validate([
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Inisialisasi array nama file
            $nama_file = [];


            if ($r->hasFile('foto')) {
            foreach ($r->file('foto') as $image) {
                $nama_file[] = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('path/produk'), end($nama_file));
            }
            } else {

            $nama_file = explode(',', $rec->foto);
            }


            $x = [
            'id' => $r->id,
            'kode' => $r->kode,
            'nama' => $r->nama,
            'idsatuan' => $r->idsatuan,
            'idkategori' => $r->idkategori,

            'tglexp' => $r->tglexp,
            'foto' => implode(',', $nama_file), // Simpan nama file foto
            'desc' => $r->desc,
            'pajang' => $r->pajang,
            ];

            DB::table('tbstok')
            ->where('id', $id)
            ->update($x);

    return view('stok.tbstok')
        ->with('judul', 'Daftar Stok')
        ->with('nama', 'Stok');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $stok = DB::table('tbstok')->where('id', $id)->first();

        if ($stok) {
            // Ambil daftar foto dari entri stok
            $fotoString = $stok->foto;

            // Pisahkan string menjadi array menggunakan koma sebagai delimiter
            $fotoArray = explode(',', $fotoString);

            // Loop through each file and delete it
            foreach ($fotoArray as $foto) {
                $filePath = 'path/produk1/' . $foto;
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus entri stok dari database
            DB::table('tbstok')->where('id', $id)->delete();
        }

    // Hapus entri stok dari database
    DB::table('tbstok')->where('id', $id)->delete();
    return view('stok.tbstok')
    ->with('judul', 'Daftar Stok')
    ->with('nama', 'Stok');


}

}
