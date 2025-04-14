@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Ringkasan Pesanan</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- Data pesanan ditampilkan di sini --}}
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total Harga</th>
                <th>Rp0</th>
            </tr>
        </tfoot>
    </table>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="mb-3">Member Status</h5>

            <div class="mb-3">
                <label class="form-label">Pilih Status Member</label>
                <select class="form-select">
                    <option value="">Pilih</option>
                    <option value="member">Member</option>
                    <option value="non_member">Bukan Member</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">No Telepon</label>
                <input type="text" class="form-control" placeholder="Masukkan nomor telepon">
            </div>

            <div class="mb-3">
                <label class="form-label">Total Bayar</label>
                <input type="text" class="form-control" placeholder="Masukkan total bayar">
            </div>
        </div>
    </div>

    <form method="POST">
        <button type="submit" class="btn btn-primary btn-lg"> Bayar </button>
    </form>
</div>
@endsection
