@extends('component.layout')

@section('title', 'Registrasi User')

@section('content')

    <div class="card">
        <div class="p-3">
            <h2>Registrasi Pengguna</h2>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
           <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required class="form-control mb-3">
                @if ($errors->has('email'))
                    <div class="text-red-600">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Aktif" required class="form-control mb-3">
                <input type="password" name="password" placeholder="Masukan Password" required class="form-control mb-3">
                @if ($errors->has('password'))
                    <div class="text-red-600">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required class="form-control mb-3">
                <select name="role" class="form-select mb-3" required>
                    <option value="" selected disabled>Pilih Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
                <button type="submit" class="btn btn-warning">Registrasi</button>
           </form>
        </div>
    </div>
@endsection
