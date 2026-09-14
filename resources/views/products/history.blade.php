@extends('layouts.master')

@section('title', 'Data History Transaksi')

@section('content')
<div class="container mb-5">

    <div class="card shadow-sm border-0">
        
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark">Daftar Transaksi Berhasil</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="historyTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>No. Invoice</th>
                            <th>Customer</th>
                            <th>Produk Dibeli (API)</th>
                            <th>Qty</th>
                            <th>Diskon</th>
                            <th>Total Bayar ($)</th>
                            <th>Waktu Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $t)
                            @foreach ($t->details as $d)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $t->invoice_number }}</span></td>
                                    <td class="fw-semibold">{{ $t->customer_name }}</td>
                                    <td>{{ $d->product_title }} <small class="text-muted">({{ $d->sku }})</small></td>
                                    <td>{{ $d->quantity }} unit</td>
                                    <td><span class="badge bg-warning text-dark">{{ $d->discount_percentage }}%</span></td>
                                    <td class="fw-bold text-success">${{ number_format($t->total_amount, 2) }}</td>
                                    <td><small>{{ \Carbon\Carbon::parse($t->transaction_date)->timezone('Asia/Jakarta') }}</small></td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#historyTable').DataTable({
            "order": [[ 6, "desc" ]],
            "language": { "sSearch": "Cari Transaksi:" }
        });
    });
</script>

@endpush