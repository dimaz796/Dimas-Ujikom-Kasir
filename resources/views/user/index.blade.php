@extends('component.layout')

@section('title','Data User')

@section('content')
    <h1>Daftar Pengguna</h1>
    <div class="me-auto">
    <a href="{{ route('user.create') }}" class="btn btn-primary ">Registrasi</a>
    </div>
    <table class="table mt-3 rounded-lg overflow-hidden shadow-lg">
        <thead class="table-dark">
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </thead>
        <tbody class="table-light">
        @forelse ($user as $data)
               <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td>{{ $data->role }}</td>
                    <td>
                        <a href="{{ route('user.edit', ['id' => $data->user_id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('user.delete', ['id' => $data->user_id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
               </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada produk</td>
                </tr>
            @endforelse
        </tbody>

    </table>

@endsection