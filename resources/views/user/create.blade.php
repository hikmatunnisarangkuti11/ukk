@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tambah User</h2>

    <div class="alert alert-success" style="display: none;">
        User berhasil ditambahkan.
    </div>

    <form action="#" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-control" required>
                <option value="Admin">Admin</option>
                <option value="Employee">Employee</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password"  class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
