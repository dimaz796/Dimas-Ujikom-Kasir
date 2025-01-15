@extends('component.layout')

@section('title', 'Edit User')

@section('content')

    <div class="card">
        <div class="p-3">
            <h2>Edit Pengguna</h2>
           <form action="{{ route('user.update',['id' => $user->user_id ]) }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ $user->name }}" required class="form-control mb-3">
                <input type="email" name="email" placeholder="Email Aktif" value="{{ $user->email }}" required class="form-control mb-3">
                <input type="password" name="password"  placeholder="Masukan Password"  class="form-control mb-3">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"  class="form-control mb-3">
                <select name="role" id="" class="form-select mb-3">
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
                <button type="submit" class="btn btn-warning">Registrasi</button>
           </form>
        </div>
    </div>
@endsection