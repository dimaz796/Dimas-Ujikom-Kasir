@extends('component.layout')

@section('title','Data User')

@section('content')
    <h1>Daftar Pengguna</h1>
    <a href="{{ route('user.create') }}" class="btn btn-success">Registrasi</a>
    <table class="table mt-3">
        <thead class="table-dark">
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <!-- <th>Aksi</th> -->
        </thead>
        <tbody>
            @forelse ($user as $data)
               <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->role }}</td>
               </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada produk</td>
                </tr>
            @endforelse
        </tbody>

    </table>

@endsection