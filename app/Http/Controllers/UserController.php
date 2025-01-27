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

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'nullable|min:4|confirmed'
        ]);

        $user = User::findOrFail($id);


        if ($request->filled('password')) {
            $validatedPassword = bcrypt($validateData['password']);
        } else {
            // Jika password tidak diisi, gunakan password lama
            $validatedPassword = $user->password;
        }

        $user->update([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'role' => $validateData['role'],
            'password' => $validatedPassword,
        ]);

        return redirect()->route('user')->with('success', 'Perubahan Berhasil Dilakukan');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user')->with('success', 'Pernghapusan Berhasil Dilakukan');
    }
}
