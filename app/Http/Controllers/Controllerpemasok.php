<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Controllerpemasok extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pemasok.tbpemasok')
        ->with('judul', 'Daftar Pemasok')
        ->with('nama', 'Pemasok');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pemasok.input')
        ->with('judul', 'Input Pemasok')
        ->with('nama', 'Pemasok');

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
        DB::table('tbpemasok')->insertgetId($x);
        return view('pemasok.tbpemasok')
        ->with('judul', 'Daftar Pemasok')
        ->with('nama', 'Pemasok');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pemasok.edit')
        ->with('judul', 'Edit Pemasok')
        ->with('nama', 'Pemasok')
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
        DB::table('tbpemasok')
        ->where('id',$r->id)
        ->update($x);
        return view('pemasok.tbpemasok')
        ->with('judul', 'Daftar Pemasok')
        ->with('nama', 'Pemasok');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        DB::table('tbpemasok')->where('id', $id)->delete();
        return view('pemasok.tbpemasok')
        ->with('judul', 'Daftar Pemasok')
        ->with('nama', 'Pemasok');

    }
}
