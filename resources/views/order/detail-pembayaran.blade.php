@extends('layouts.app', ['title' => 'Detail Pembayaran', 'page' => 'detail-pembayaran'])

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Pembayaran</h2>

    <div class="card p-3 mb-3">
        <p><strong>MEMBER SEJAK :</strong> -</p>
        <p><strong>MEMBER POIN :</strong> -</p>
    </div>

    <div class="card p-3 mb-3">
        <p><strong>Nomor Telepon :</strong> -</p>
        <p><strong>Status Member :</strong> -</p>
    </div>

    <div class="card p-3 mb-3">
        <h5><strong>Invoice - </strong></h5>
        <p><strong>-</strong></p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Quantity</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>-</td>
                <td>Rp. -</td>
                <td>-</td>
                <td>Rp. -</td>
            </tr>
        </tbody>
    </table>

    <div class="card p-3 mb-3">
        <p><strong>POIN DIGUNAKAN :</strong> -</p>
        <p><strong>KASIR :</strong> -</p>
        <p><strong>KEMBALIAN :</strong> Rp. -</p>
        <p class="fw-bold"><strong>TOTAL :</strong> Rp. -</p>
    </div>

    <a href="#" class="btn btn-primary mt-3">Selesai</a>
</div>
@endsection
