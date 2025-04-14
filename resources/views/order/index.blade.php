@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Penjualan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <form action="{{ route('orders.index') }}" method="GET" class="d-flex align-items-center flex-grow-1 gap-2">
                <label for="per_page" class="mb-0">Tampilkan:</label>
                <select name="per_page" id="per_page" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>

                <input type="text" name="search" class="form-control flex-grow-1" placeholder="Cari berdasarkan Nama Pelanggan" value="{{ request('search') }}">

                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a class="btn btn-success" href="{{ route('orders.export') }}">
                <i class="fa fa-download"></i> Export Order Data
            </a>

            @if (Auth::user()->role != 'Admin')
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    Tambah Penjualan
                </a>
            @endif
        </div>

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
                @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ $orders->firstItem() + $index }}</td>
                        <td>{{ $order->customer_name ?? $order->status }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>{{ $order->user->name ?? 'Admin' }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#orderDetailModal{{ $order->id }}">
                                Lihat
                            </button>

                            <!-- Modal Content - Detail Order -->
                            <div class="modal fade" id="orderDetailModal{{ $order->id }}" tabindex="-1"
                                aria-labelledby="orderDetailModalLabel{{ $order->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="orderDetailModalLabel{{ $order->id }}">Detail Order</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            @php
                                                $toko = \App\Models\Toko::first();  // Ambil data toko pertama
                                            @endphp
                                            <p><strong>Nama Toko:</strong> {{ $toko->nama_toko }}</p>
                                            <p><strong>Alamat:</strong> {{ $toko->alamat }}</p>
                                            <p><strong>No. HP:</strong> {{ $toko->no_hp }}</p>
                                        </div>
                                        <div class="modal-body">
                                            @php
                                                $member = \App\Models\Member::where('phone', $order->phone_number)->first();
                                            @endphp

                                            <p><strong>Member Status:</strong>
                                                {{ $order->status == 'Member' ? 'Member' : 'Bukan Member' }}
                                            </p>

                                            @if ($member)
                                                <p><strong>No. HP:</strong> {{ $member->phone }}</p>
                                                <p><strong>Poin Member:</strong> {{ number_format($member->points, 0, ',', '.') }}</p>
                                                <p><strong>Bergabung Sejak:</strong> {{ \Carbon\Carbon::parse($member->created_at)->translatedFormat('d F Y') }}</p>
                                            @endif

                                            @php $products = json_decode($order->products, true); @endphp
                                            <table class="table table-bordered mt-3">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Produk</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($products as $product)
                                                        <tr>
                                                            <td>{{ $product['name'] }}</td>
                                                            <td>{{ $product['quantity'] }} KG </td>
                                                            <td>Rp. {{ number_format($product['price'], 0, ',', '.') }}</td>
                                                            <td>Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <p><strong>Total:</strong> Rp. {{ number_format($order->total, 0, ',', '.') }}</p>
                                            <p><strong>Dibuat pada:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                                            <p><strong>Oleh:</strong> {{ $order->user_id == 1 ? 'Admin' : 'Petugas' }}</p>

                                            <!-- Modal Content - Info Toko -->
                                            @php
                                                $toko = \App\Models\Toko::first();  // Ambil data toko pertama
                                            @endphp
                                            <div class="modal mt-3">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Informasi Toko</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama Toko:</strong> {{ $toko->nama_toko }}</p>
                                                    <p><strong>Alamat:</strong> {{ $toko->alamat }}</p>
                                                    <p><strong>No. HP:</strong> {{ $toko->no_hp }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('orders.downloadPDF', $order->id) }}" class="btn btn-secondary btn-sm" target="_blank">
                                <i class="fa fa-file-pdf"></i> Export PDF
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
@endsection
