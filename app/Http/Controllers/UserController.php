<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!$search) {
            return redirect()->route('user');
        }

        $user = User::where('status','active')
                     ->where('name', 'like', '%' . $search . '%')->oldest()->paginate(10);

        return view('user.index', compact('user'));
    }

    public function index()
    {
        $user = User::where('status','active')
                     ->orderBy('created_at', 'asc')->paginate(10);

        return view('user.index', compact('user'));
    }

    public function create()
    {
        return view('user.tambah');
    }

    public function store(Request $request)
    {
        $messages = [
            'email.unique' => 'Email sudah digunakan, coba email lain.',
            'password.confirmed' => 'Password tidak sama, harap periksa kembali password dan konfirmasi password Anda.',
        ];

        $validateData = $request->validate([
           'name' => 'required',
           'email' => 'required|email|unique:users,email',
           'role' => 'required',
           'password' => 'required|confirmed'
        ],$messages);


        try{
            User::create([
                'name' => $validateData['name'],
                'email' => $validateData['email'],
                'role' => $validateData['role'],
                'password' => bcrypt($validateData['password']),
            ]);

            return redirect()->route('user')->with('success','Registrasi Berhasil');
        } catch (\Exception $e){
            return redirect()->route('user')->with('error', 'Registrasi Gagal: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'email.unique' => 'Email sudah digunakan, coba email lain.',
            'password.confirmed' => 'Password tidak sama, harap periksa kembali password dan konfirmasi password Anda.',
        ];

        $validateData = $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id,'user_id'),
            ],
            'role' => 'required',
            'password' => 'nullable|confirmed'
        ], $messages);

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
        $user->status = 'inactive';
        $user->save();

        return redirect()->route('user')->with('success', 'Penghapusan Berhasil Dilakukan');
    }
}
