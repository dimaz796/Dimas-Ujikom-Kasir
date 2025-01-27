@extends('component.layout')

@section('title', 'Registrasi User')

@section('content')

    <div class="card">
        <div class="p-3">
            <h2>Registrasi Pengguna</h2>
           <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap" required class="form-control mb-3">
                <input type="email" name="email" placeholder="Email Aktif" required class="form-control mb-3">
                <input type="password" name="password" placeholder="Masukan Password" required class="form-control mb-3">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required class="form-control mb-3">
                <select name="role" id="" class="form-select mb-3" required>
                    <option value="" selected disabled>Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
                <button type="submit" class="btn btn-warning">Registrasi</button>
           </form>
        </div>
    </div>
@endsection