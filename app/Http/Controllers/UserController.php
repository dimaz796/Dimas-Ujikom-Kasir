<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('created_at', 'asc')->get();

        return view('user.index', compact('user'));
    }

    public function create()
    {
        return view('user.tambah');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
           'name' => 'required',
           'email' => 'required|email',
           'role' => 'required',
           'password' => 'required|min:4|confirmed'
        ]);


        User::create([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'role' => $validateData['role'],
            'password' => bcrypt($validateData['password']),
        ]);

        return redirect()->route('user')->with('success','Registrasi Berhasil');
    }
}
