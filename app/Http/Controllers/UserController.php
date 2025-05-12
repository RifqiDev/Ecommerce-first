<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;


class UserController extends Controller
{
    public function register()
    {
        $data['title'] = 'Register';
        return view('register', $data);
    }

    public function register_action(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            'image' => 'required',
        ]);



        $image= $request->file('image');
        $filename= date('Y-m-d').$image->getClientOriginalName();
        $path= 'image-user1/'.$filename;
        Storage::disk('public')->put($path, file_get_contents($image));

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'image' => $filename,
        ]);
        $user->save();
        return redirect()->intended('login');


    }


    public function login()
    {
        $data['title'] = 'Login';
        return view('login', $data);
    }

    public function login_action(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Get the authenticated user

            // Pass the user data to the view, including the image
            return view('templetkampus', ['user' => $user]);

        }


        // Authentication failed
        return redirect()->back()->withErrors([
            'username' => 'Invalid credentials',
        ]);
    }



    public function password()
    {
        $data['title'] = 'Change Password';
        return view('password', $data);
    }

    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return back()->with('success', 'Password changed!');
    }


}
