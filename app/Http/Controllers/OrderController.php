<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Toko;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Barryvdh\DomPDF\Facade\Pdf;
class OrderController extends Controller
{
    public function downloadPDF($id)
    {
        $order = Order::findOrFail($id);
        $orderData = json_decode($order->products, true);
        $member = Member::where('phone', $order->phone_number)->first();
        $toko = Toko::first();
        
        $paymentDetails = [
            'order'           => $order,
            'kasir'           => Auth::user()->role === 'Employee' ? 'Petugas' : Auth::user()->role,
            'created_at'      => $order->created_at->format('d M Y H:i'),
            'invoice'         => $order->invoice,
            'member_since'    => $member ? $member->created_at->format('d M Y') : '-',
            'member_poin'     => $member->points ?? 0,
            'is_member'       => $order->status === 'Member' ? 'member' : 'bukan member',
            'phone'           => $order->phone_number,
            'products'        => $orderData,
            'kembalian'       => $order->kembalian,
            'total'           => $order->total + $order->poin_digunakan,
            'total_asli'      => $order->total + $order->poin_digunakan,
            'poin_digunakan'  => $order->poin_digunakan,
            'poin_didapat'    => floor($order->total * 0.01),
            'total_pay'       => $order->total + $order->kembalian,
            'toko' => $toko,
        ];

        $pdf = Pdf::loadView('order.pdf', compact('paymentDetails'))
                  ->setPaper('A5', 'portrait');

        return $pdf->download('Nota-Pembayaran-' . $order->invoice . '.pdf');
    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $search = $request->input('search', '');

        $orders = Order::when($search, function ($query, $search) {
            if (strtolower(trim($search)) === 'bukan member') {
                return $query->whereNull('customer_name');
            } else {
                return $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%");
                });
            }
        })->paginate($perPage);

        return view('order.index', compact('orders'));
    }

    public function summary(Request $request)
    {
        // dd($request->all());
        $orderData = json_decode($request->order_data, true);

        if (empty($orderData)) {
            return redirect()->back()->with('error', 'Data order tidak ditemukan.');
        }

        return view('order.summary', compact('orderData'));
    }

    public function member(Request $request)
    {
        $orderData = json_decode($request->order_data, true);
        $statusMember = $request->is_member;
        $nomorTelepon = $request->phone;
        $jumlahBayar = $request->total_pay_hidden;
        $inputNama = $request->customer_name_input;

        if (empty($orderData)) {
            return redirect()->back()->with('error', 'Data order tidak ditemukan.');
        }

        $member = null;
        $namaPengguna = null;
        $poinSaatIni = 0;
        $countSale = 0;

        if ($statusMember === 'member') {
            $member = Member::where('phone', $nomorTelepon)->first();
            $namaPengguna = $member ? $member->customer_name : null;
            $poinSaatIni = $member ? $member->points : 0;
            $countSale = Order::where('phone_number', $nomorTelepon)->count();
        }

        return view('order.member', compact('orderData', 'statusMember', 'nomorTelepon', 'jumlahBayar', 'namaPengguna', 'poinSaatIni', 'countSale'));
    }


    public function detailPembayaran(Request $request)
    {
        $orderData = json_decode($request->order_data, true);
        $statusMember = $request->is_member;
        $totalPrice = (int) $request->total_price;
        $totalPaid = (int) $request->total_pay_hidden;
        $customerName = $request->customer_name_input;
        $phone = $request->phone;

        $member = null;

        // Cek apakah pembeli adalah member
        if ($statusMember === 'member') {
            $member = Member::firstOrCreate(
                ['phone' => $phone],
                [
                    'customer_name' => $customerName,
                    'points' => 0,
                    'is_member' => 1,
                ]
            );

            // Update nama customer jika berubah
            $member->update(['customer_name' => $customerName]);
        }

        $poinDigunakan = (int) $request->poin_digunakan;
        $poinDariPembelian = floor($totalPrice * 0.01);
        $poinTotalDigunakan = 0;
        $totalSetelahPoin = $totalPrice;

        // Proses poin jika member
        if ($member) {
            $totalPoinTersedia = $member->points + $poinDariPembelian;
            $poinDigunakan = min($totalPoinTersedia, $poinDigunakan);

            if ($poinDigunakan > 0) {
                $totalSetelahPoin = $totalPrice - $poinDigunakan;
                $member->decrement('points', min($member->points, $poinDigunakan));
                $poinTotalDigunakan = $poinDigunakan;
                $poinDariPembelian = 0; // tidak dapat poin dari pembelian karena pakai poin
            } else {
                $member->increment('points', $poinDariPembelian);
            }
        }

        // Generate invoice
        $lastInvoiceNumber = Order::max('invoice');
        $lastInvoiceNumber = (int) filter_var($lastInvoiceNumber, FILTER_SANITIZE_NUMBER_INT);
        $nextInvoiceNumber = $lastInvoiceNumber + 1;

        // Simpan order
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $customerName,
            'total' => max(0, $totalSetelahPoin),
            'phone_number' => $phone,
            'status' => $statusMember === 'member' ? 'Member' : 'Bukan Member',
            'products' => json_encode($orderData),
            'invoice' => '#' . $nextInvoiceNumber,
            'kembalian' => max(0, $totalPaid - $totalSetelahPoin),
            'poin_digunakan' => $poinTotalDigunakan,
        ]);

        // Kurangi stok produk
        foreach ($orderData as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->decrement('stock', (int) $item['quantity']);
            }
        }

        $toko = Toko::first();

        return view('order.detail-pembayaran', [
            'paymentDetails' => [
                'order' => $order,
                'kasir' => Auth::user()->role === 'Employee' ? 'Petugas' : Auth::user()->role,
                'created_at' => $order->created_at->format('d M Y'),
                'invoice' => $order->invoice,
                'member_since' => $order->created_at->format('d M Y'),
                'member_poin' => $member->points ?? 0,
                'is_member' => $statusMember,
                'phone' => $phone,
                'products' => $orderData,
                'kembalian' => $order->kembalian,
                'total' => $totalSetelahPoin,
                'total_asli' => $totalPrice,
                'poin_digunakan' => $poinTotalDigunakan,
                'poin_didapat' => $poinDariPembelian,
                'total_pay' => $totalPaid,
                'toko' => $toko,
            ],
        ]);
    }


    public function create()
    {
        $products = Product::all();
        return view('order.create', compact('products'));
    }

    public function submit(Request $request)
    {
        $orderData = json_decode($request->order_data, true);
        $total = $request->total;

        $member = null;
        if ($request->member_status === 'member') {
            $member = Member::updateOrCreate(
                ['phone' => $request->phone],
                ['is_member' => true]
            );
        }

        $order = Order::create([
            'total' => $total,
            'member_id' => $member ? $member->id : null,
        ]);

        foreach ($orderData as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('order.success')->with('success', 'Pesanan berhasil dibuat!');
    }
}
