@extends('layouts.app', ['title' => 'Detail Pembayaran', 'page' => 'detail-pembayaran'])

@section('content')

    <div class="receipt">
        <h2>Nota Pembayaran</h2>
        <div class="store-info text-center mb-4">
            <h3>{{ $paymentDetails['toko']->nama_toko }}</h3>
            <p>{{ $paymentDetails['toko']->alamat }}</p>
            <p>No. HP: {{ $paymentDetails['toko']->no_hp }}</p>
        </div>


        <div class="section">
            <p><strong>Invoice:</strong> {{ $paymentDetails['invoice'] }}</p>
            <p><strong>Kasir:</strong> {{ $paymentDetails['kasir'] }}</p>
            <p><strong>Status:</strong> {{ $paymentDetails['is_member'] }}</p>
        </div>
        <div class="section">
            @if ($paymentDetails['is_member'] === 'member')
            <p><strong>Member Sejak:</strong> {{ $paymentDetails['member_since'] }}</p>
            <p><strong>Member Poin:</strong> {{ $paymentDetails['poin_didapat'] }}</p>
            @endif
        </div>

        <div class="section highlight">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align:right">Harga</th>
                        <th style="text-align:right">Quantity</th>
                        <th style="text-align:right">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentDetails['products'] as $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td style="text-align:right">Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                            <td style="text-align:right">{{ $product['quantity'] }}kg</td>
                            <td style="text-align:right">Rp {{ number_format($product['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total">
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($paymentDetails['total_pay'], 0, ',', '.') }}</p>
            <p><strong>Poin Digunakan:</strong> {{ number_format($paymentDetails['poin_digunakan'], 0, ',', '.') }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($paymentDetails['total_asli'] - $paymentDetails['poin_digunakan'], 0, ',', '.') }}</p>
            <p><strong>Kembalian:</strong> Rp {{ number_format($paymentDetails['kembalian'], 0, ',', '.') }}</p>
        </div>

        <div class="text-center">
            <p>--- Terima Kasih ---</p>
        </div>

        <div class="btn-container">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('orders.downloadPDF', ['id' => $paymentDetails['order']->id]) }}" class="btn btn-primary">Unduh PDF</a>
        </div>
    </div>
@endsection
