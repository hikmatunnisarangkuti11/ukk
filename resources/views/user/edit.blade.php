@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit User</h2>

    <!-- Error alert dummy (tidak aktif) -->
    <div class="alert alert-danger" style="display: none;">
        <ul>
            <li>Contoh error validasi.</li>
        </ul>
    </div>

    <form action="#" method="POST">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="Contoh Nama" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="contoh@email.com" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="Admin" selected>Admin</option>
                <option value="Employee">Employee</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="#" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
