<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class user extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.tbuser')
        ->with('judul', 'Daftar User');
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
        return view('user.edit')
        ->with('judul', 'Edit User')
        ->with('nama', 'User')
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
        $x=array(
            'role'=> $r->role,

        );

        DB::table('users')
        ->where('id',$r->id)
        ->update($x);
        return view('user.tbuser')
        ->with('judul', 'Edit User')
        ->with('nama', 'User');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
