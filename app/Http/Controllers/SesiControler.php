<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SesiControler extends Controller
{
    function index(){
        return view('auth.login');

    }

    function login (Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ],[
            'email.required'=>'Email Wajib Diisi',
            'password.required'=>'Password Wajib Diisi',
        ]);

        $infologin = [
            'email' => $request -> email,
            'password' => $request -> password
            ];


            if(Auth::attempt($infologin)) {
                if (Auth::user()->role == 'admin') {
                    return redirect('admin');
                } elseif (Auth::user()->role == 'user') {
                    return redirect('user');
                }
            }


    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('index');
    }

    public function register()
    {
        $data['title'] = 'Register';
        return view('auth.register', $data);
    }

    public function register_action(Request $r)
    {



    $validate = $r->validate([
        'name' => 'required|string|max:200',
        'email' => 'required|string|email|max:200|unique:users',
        'password' => 'required|string|min:8',

    ]);

    $user = new User();
    $user->name = $validate['name'];
    $user->email = $validate['email'];
    $user->password = Hash::make($validate['password']) ;
    $user->save();

    
    return view('auth.login');
}

}
