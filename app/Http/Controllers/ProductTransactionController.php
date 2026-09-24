<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ProductTransactionController extends Controller
{
    // URL Endpoint REST API DummyJSON
    private $apiUrl = 'https://dummyjson.com/products';

    /**
     * 1. Menampilkan Katalog Produk dari API External DummyJSON
     */
    public function index()
    {
        // Mengirim GET Request menggunakan HTTP Client Laravel
        $response = Http::get($this->apiUrl, [
            'limit' => 30 // Ambil 30 produk pertama
        ]);

        $products = [];
        if ($response->successful()) {
            $products = $response->json()['products'];
        }

        // $products = Product::latest()->get(); // Mengambil semua produk dari database lokal   

        return view('products.index', compact('products'));
    }

    /**
     * 2. Memproses Transaksi Pembelian / Checkout Produk API
     */
    public function store(Request $request, Product $product)
    {
        // Validasi input form checkout
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_id'    => 'required|integer',
            'quantity'      => 'required|integer|min:1',
        ]);

        // $product = Product::find($request->product_id);
        // Fetch detail produk spesifik dari API DummyJSON berdasarkan ID
        // if ($product = Product::find($request->product_id)) {
        //     $product = $product;
        // } else {
        //     $responseApi = Http::get("{$this->apiUrl}/{$request->product_id}");
        // }

        $response = Http::get("{$this->apiUrl}/{$request->product_id}");

        if ($response->failed()) {
            return back()->with('error', 'Gagal mengambil data produk dari API DummyJSON.');
        }
        
        $product = $response->json();

        // if (!$product) {
        // } else {
        //     $product = $product;
        // }

        // Validasi ketersediaan stok produk API
        // dd($product['stock'], $request->quantity);
        // if ($request->quantity > $product->stock) {

        if ($request->quantity > $product['stock']) {
            return back()->with('error', 'Jumlah pembelian melebihi stok yang tersedia (' . $product['stock'] . ').');
        }

        // Kalkulasi Harga (Diskon %)
        // $price = $product->price;
        // $discount = $product->discountPercentage ?? 0;
        // $priceAfterDiscount = $price - ($price * ($discount / 100));
        // $subtotal = $priceAfterDiscount * $request->quantity;

        $price = $product['price'];
        $discount = $product['discountPercentage'] ?? 0;
        $priceAfterDiscount = $price - ($price * ($discount / 100));
        $subtotal = $priceAfterDiscount * $request->quantity;

        // DB Transaction untuk menjamin integritas data transaksi
        DB::beginTransaction();
        try {
            // A. Simpan Header Transaksi
            $transaction = Transaction::create([
                'invoice_number'   => 'INV-' . strtoupper(Str::random(8)),
                'customer_name'    => $request->customer_name,
                'total_amount'     => $subtotal,
                'transaction_date' => now(),
            ]);

            // B. Simpan Detail Transaksi
            TransactionDetail::create([
                'transaction_id'      => $transaction->id,
                'external_product_id' => $product['id'],
                'product_title'       => $product['title'],
                'sku'                 => $product['sku'] ?? 'N/A',
                'price'               => $price,
                'discount_percentage' => $discount,
                'quantity'            => $request->quantity,
                'subtotal'            => $subtotal,
            ]);

            // $product->update([
            //     'stock' => $product->stock - $request->quantity,
            // ]);

            LogHelper::record(Auth::user()->email ." telah melakukan input transaksi a.n. ". $request->customer_name ." (". $transaction->invoice_number .")!");

            DB::commit();

            return redirect()->route('transactions.history')
                ->with('success', 'Transaksi berhasil disimpan! No Invoice: ' . $transaction->invoice_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * 3. Menampilkan Riwayat Transaksi Lokal
     */
    public function history()
    {
        $transactions = Transaction::with('details')->latest()->get();
        return view('products.history', compact('transactions'));
    }

    public function printHistory(Request $request)
    {
        // 1. Ambil data transaksi beserta detail produk eksternalnya
        $query = Transaction::with('details')->latest();

        // Opsional: Filter berdasarkan rentang tanggal jika ada request dari form
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        $transactions = $query->get();

        // 2. Ringkasan Total Akumulasi Laporan
        $totalGrand = $transactions->sum('total_amount');
        $totalQty   = $transactions->flatMap->details->sum('quantity');

        // 3. Return ke Blade Khusus Laporan Cetak PDF
        return view('products.print_history', compact('transactions', 'totalGrand', 'totalQty'));
    }

}

