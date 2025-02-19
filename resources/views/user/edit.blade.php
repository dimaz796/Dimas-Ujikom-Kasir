@extends('component.layout')

@section('title', 'Edit User')

@section('content')

    <div class="card">
        <div class="p-3">
            <h2>Edit Pengguna</h2>
           <form action="{{ route('user.update',['id' => $user->user_id ]) }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ $user->name }}" required class="form-control mb-3">
                @if ($errors->has('email'))
                    <div class="text-red-600">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <input type="email" name="email" placeholder="Email Aktif" value="{{ $user->email }}" required class="form-control mb-3">
                <input type="password" name="password"  placeholder="Masukan Password"  class="form-control mb-3">
                @if ($errors->has('password'))
                    <div class="text-red-600">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"  class="form-control mb-3">
                <select name="role" id="" class="form-select mb-3" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
                <button type="submit" class="btn btn-warning">Edit</button>
           </form>
        </div>
    </div>
@endsection
