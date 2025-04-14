@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Produk</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="6">
                        <button class="btn btn-primary">Tambah Produk</button>
                    </th>
                </tr>
                <tr>
                    <th colspan="6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari nama, harga, atau stok...">
                            <button class="btn btn-outline-secondary" type="button">Cari</button>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td style="text-align: center; vertical-align: middle;">
                        <img src="example.jpg" alt="Image" width="150" height="100">
                    </td>
                    <td>Contoh Produk</td>
                    <td>Rp 50.000</td>
                    <td>20</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Edit</button>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateStockModal1">Update Stok</button>
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Stok -->
<div class="modal fade" id="updateStockModal1" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Stok Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" value="Contoh Produk" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" class="form-control" value="20" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
