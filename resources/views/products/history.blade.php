@extends('layouts.master')

@section('title', 'Data History Transaksi')

@section('content')

<div class="card shadow-sm border-0">
    
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold text-dark">Daftar Transaksi Berhasil</h5>
        <a href="{{ route('products.index') }}" class="btn btn-outline-danger">
            Kembali
        </a>
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

@endsection

@push('scripts')
    <!-- BUTTONS EXTENSION JS -->
    <script src="{{ asset('/js/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('/js/data-table/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/js/data-table/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('/js/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/js/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/js/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/js/data-table/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('/js/data-table/datatables-init.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            var table = $('#historyTable').DataTable({
                // Pengaturan Layout (dom) untuk Menampilkan Tombol di atas Tabel
                dom: '<"d-flex justify-content-between align-items-center mb-3"<"btn-group"B><"search-box"f>>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '📋 Copy',
                        className: 'btn btn-secondary btn-sm'
                    },
                    {
                        extend: 'excelHtml5',
                        text: '📊 Excel (.xlsx)',
                        className: 'btn btn-success btn-sm',
                        title: 'Laporan_Transaksi_Penjualan'
                    },
                    {
                        extend: 'csvHtml5',
                        text: '📄 CSV',
                        className: 'btn btn-info btn-sm text-white',
                        title: 'Laporan_Transaksi_Penjualan'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '📕 PDF',
                        className: 'btn btn-danger btn-sm',
                        title: 'Laporan Transaksi Penjualan',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    {
                        extend: 'print',
                        text: '🖨️ Print',
                        className: 'btn btn-dark btn-sm'
                    },
                    {
                        extend: 'colvis',
                        text: '👁️ Visibilitas Kolom',
                        className: 'btn btn-warning btn-sm text-dark'
                    },
                    // Custom Button untuk Ekspor JSON Format
                    {
                        text: '{ } JSON',
                        className: 'btn btn-primary btn-sm',
                        action: function (e, dt, node, config) {
                            var data = dt.buttons.exportData();
                            var jsonString = JSON.stringify(data, null, 2);
                            
                            // Buat file blob JSON & trigger download otomatis
                            var blob = new Blob([jsonString], { type: "application/json" });
                            var link = document.createElement("a");
                            link.href = URL.createObjectURL(blob);
                            link.download = "Laporan_Transaksi_" + new Date().toISOString().slice(0,10) + ".json";
                            link.click();
                        }
                    }
                ],
                language: {
                    search: "Cari Data Transaksi:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
                }
            });
        });
    </script>

@endpush