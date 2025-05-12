<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Controllerpelanggan extends Controller
{
    public function index()
    {
        return view('pelanggan.tbpelanggan')
        ->with('judul', 'Daftar Pelanggan')
        ->with('nama', 'Pelanggan');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggan.input')
        ->with('judul', 'Input Pelanggan')
        ->with('nama', 'Pelanggan');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $x=array(
            'id'=> $r->id,
            'kode'=> $r->kode,
            'nama'=> $r->nama,
            'alamat'=> $r->alamat,
            'hp'=> $r->hp,
            'top'=> $r->top,
        );
        DB::table('tbpelanggan')->insertgetId($x);
        return view('pelanggan.tbpelanggan')
        ->with('judul', 'Daftar Pelanggan')
        ->with('nama', 'Pelanggan');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pelanggan.edit')
        ->with('judul', 'Edit Pelanggan')
        ->with('nama', 'Pelanggan')
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
    public function update(Request $r)
    {
        $x=array(
            'id'=> $r->id,
            'kode'=> $r->kode,
            'nama'=> $r->nama,
            'alamat'=> $r->alamat,
            'hp'=> $r->hp,
            'top'=> $r->top,
        );
        DB::table('tbpelanggan')
        ->where('id',$r->id)
        ->update($x);
        return view('pelanggan.tbpelanggan')
        ->with('judul', 'Daftar Pelanggan')
        ->with('nama', 'Pelanggan');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        DB::table('tbpelanggan')->where('id', $id)->delete();
        return view('pelanggan.tbpelanggan')
        ->with('judul', 'Daftar Pelanggan')
        ->with('nama', 'Pelanggan');


    }

}
