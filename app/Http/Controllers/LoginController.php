<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }else{
            return view('auth.login');
        }
    }

    public function cekLogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if(Auth::attempt($data)){
            return redirect()->route('home');
        }else{
            Session::flash('error','Username Atau Password Salah!');
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();

        Session::flash('message', 'Anda telah berhasil logout!');
        return redirect()->route('login');
    }
    
}
