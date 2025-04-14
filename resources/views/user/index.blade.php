@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar User</h2>

    <!-- Alert sukses -->
    <div class="alert alert-success" style="display: none;">
        User berhasil ditambahkan.
    </div>

    <a href="#" class="btn btn-primary mb-3">Tambah User</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>user1@example.com</td>
                <td>Nama User 1</td>
                <td>Admin</td>
                <td>
                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>user2@example.com</td>
                <td>Nama User 2</td>
                <td>Consultant</td>
                <td>
                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
