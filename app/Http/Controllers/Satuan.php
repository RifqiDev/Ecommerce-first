<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Satuan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('satuan.tbsatuan')
        ->with('judul', 'Daftar Satuan')
        ->with('nama', 'Satuan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('satuan.input')
        ->with('judul', 'Daftar Satuan')
        ->with('nama', 'Satuan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $r)
    {
        $x=array(
            'id'=> $r->id,
            'nama'=> $r->nama,
            'nilai' => $r->nilai


        );
        DB::table('tbsatuan')->insertgetId($x);
        return view('satuan.tbsatuan')
        ->with('judul', 'Daftar Satuan')
        ->with('nama', 'Satuan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('satuan.edit')
        ->with('judul', 'Daftar Satuan')
        ->with('nama', 'Satuan')
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
        $x=array(
            'id'=> $r->id,
            'nama'=> $r->nama,
            'nilai' => $r->nilai

        );

        DB::table('tbsatuan')
        ->where('id',$r->id)
        ->update($x);
        return view('satuan.tbsatuan')
        ->with('judul', 'Daftar Satuan')
        ->with('nama', 'Satuan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('tbsatuan')->where('id', $id)->delete();
        return view('satuan.tbsatuan')
        ->with('judul', 'Daftar Satuan')
        ->with('nama', 'Satuan');
    }
}
