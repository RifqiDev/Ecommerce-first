<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Admin extends Controller
{
    function index(){
        return view('welcomead')
        ->with('judul', 'Daftar Stok');;
    }
    function user(){
        return view('index')
        ->with('judul', '');;
    }
}
