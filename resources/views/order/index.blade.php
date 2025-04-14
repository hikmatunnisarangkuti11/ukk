@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Penjualan</h2>

    <div class="alert alert-success">Data berhasil disimpan!</div>

    <a class="btn btn-success float-end" href="#"><i class="fa fa-download"></i> Export Order Data</a>
    <a href="#" class="btn btn-primary mb-3">Tambah Pembelian</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
                <th>Dibuat Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>2025-04-09</td>
                <td>Rp 1.000.000</td>
                <td>Admin</td>
                <td>
                    <form action="#" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-warning btn-sm">Update</button>
                    </form>
                    <a href="#" class="btn btn-secondary btn-sm" target="_blank">
                        <i class="fa fa-file-pdf"></i> Export PDF
                    </a>
                </td>
            </tr>
            <!-- Tambahkan baris dummy lainnya jika perlu -->
        </tbody>
    </table>

    <!-- Dummy pagination -->
    <nav>
        <ul class="pagination">
            <li class="page-item disabled"><span class="page-link">«</span></li>
            <li class="page-item active"><span class="page-link">1</span></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">»</a></li>
        </ul>
    </nav>
</div>
@endsection
