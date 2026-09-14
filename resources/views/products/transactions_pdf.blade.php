@extends('layouts.master')

@section('title', 'Laporan Transaksi')

@section('content')

@endsection
    <!-- Tombol Bantuan Manual Jika Auto Print Dicegah Browser -->
    <div class="no-print mb-4 d-flex justify-content-between align-items-center bg-light p-3 rounded border">
        <div>
            <strong>📌 Mode Cetak Laporan PDF:</strong> Jendela dialog cetak akan muncul otomatis.
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary btn-sm">🖨️ Cetak / Save PDF</button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm">❌ Tutup Halaman</button>
        </div>
    </div>

    <!-- KOP LAPORAN TRANSAKSI -->
    <div class="text-center mb-4 pb-3 border-bottom border-2 border-dark">
        <h3 class="fw-bold mb-1 text-uppercase">LAPORAN RIWAYAT TRANSAKSI PENJUALAN</h3>
        <p class="mb-0 text-muted">Aplikasi Marketplace DummyJSON x Laravel Enterprise</p>
        <small class="text-secondary">Dicetak Pada: {{ now()->translatedFormat('l, d F Y - H:i') }} WIB</small>
    </div>

    <!-- TABEL DATA LAPORAN -->
    <table class="table table-bordered align-middle mb-4">
        <thead class="table-dark text-center">
            <tr>
                <th width="40">No</th>
                <th>No. Invoice</th>
                <th>Nama Customer</th>
                <th>Produk Dibeli (API)</th>
                <th>Qty</th>
                <th>Diskon (%)</th>
                <th>Total Bayar ($)</th>
                <th>Waktu Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($transactions as $t)
                @foreach ($t->details as $d)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="fw-bold">{{ $t->invoice_number }}</td>
                        <td>{{ $t->customer_name }}</td>
                        <td>{{ $d->product_title }} <small class="text-muted">({{ $d->sku }})</small></td>
                        <td class="text-center">{{ $d->quantity }}</td>
                        <td class="text-center">{{ $d->discount_percentage }}%</td>
                        <td class="text-end fw-bold">${{ number_format($t->total_amount, 2) }}</td>
                        <td class="text-center"><small>{{ \Carbon\Carbon::parse($t->transaction_date)->format('d/m/Y H:i') }}</small></td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center py-3">Belum ada data transaksi yang dicetak.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot class="table-light fw-bold">
            <tr>
                <td colspan="4" class="text-end">TOTAL AKUMULASI KESELURUHAN:</td>
                <td class="text-center">{{ $totalQty }} unit</td>
                <td></td>
                <td class="text-end text-success">${{ number_format($totalGrand, 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- TANDA TANGAN / LEMBAR PENGESAHAN -->
    <div class="row mt-5 pt-3">
        <div class="col-8"></div>
        <div class="col-4 text-center">
            <p class="mb-1">Petugas Kasir / Admin,</p>
            <br><br><br>
            <p class="fw-bold text-decoration-underline mb-0">( ____________________ )</p>
            <small class="text-muted">ID Petugas: {{ auth()->user()->name ?? 'Administrator' }}</small>
        </div>
    </div>


@push('styles')
    <style>
        /* CSS Khusus Cetak / Print Media */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
            body {
                background-color: #fff !important;
                font-size: 11pt;
                color: #000;
            }
            .no-print {
                display: none !important;
            }
            .table-dark {
                background-color: #343a40 !important;
                color: #fff !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- SCRIPT JAVASCRIPT: AUTO PRINT & AUTO CLOSE PAGE -->
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            // 1. Panggil dialog cetak browser otomatis saat halaman selesai di-load
            setTimeout(() => {
                window.print();
            }, 500);
        });

        // 2. Deteksi event setelah dialog cetak ditutup (baik saat diprint/save PDF maupun dibatalkan)
        window.onafterprint = function() {
            // Tutup tab/halaman otomatis
            window.close();
        };

        // Fallback untuk browser modern jika onafterprint tidak ter-trigger
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (!mql.matches) {
                window.close();
            }
        });
    </script>

@endpush