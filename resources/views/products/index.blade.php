@extends('layouts.master')

@section('title', 'Data Produk & Transaksi')

@section('content')
<div class="container mb-5">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold text-dark">Daftar Transaksi Berhasil</h5>
            <a href="{{ route("transactions.history") }}" class="btn btn-primary">Lihat Riwayat Transaksi</a>
        </div>
        {{-- <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-cyan" style="color: #0E7490;">Katalog Produk Real-Time (REST API External)</h5>
        </div> --}}
        <div class="card-body">
            <div class="table-responsive">
                <table id="productTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Gambar</th>
                            <th>SKU / Brand</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga ($)</th>
                            <th>Diskon (%)</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)
                            <tr>
                                <td>
                                    <img src="{{ $p['thumbnail'] ?? asset('img/err/broken-chain-isolated-icon-J701CX.jpg') }}" alt="{{ $p['title'] }}" class="rounded img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $p['sku'] ?? 'N/A' }}</span><br>
                                    <small class="text-muted">{{ $p['brand'] ?? 'Generic' }}</small>
                                </td>
                                <td class="fw-semibold">{{ $p['title'] }}</td>
                                <td><span class="badge bg-info text-dark">{{ ucfirst($p['category']) }}</span></td>
                                <td class="fw-bold text-success">${{ number_format($p['price'], 2) }}</td>
                                <td><span class="badge bg-warning text-dark">{{ $p['discountPercentage'] }}% OFF</span></td>
                                <td>
                                    <span class="badge {{ $p['stock'] > 10 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $p['stock'] }} unit
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-primary btn-sm btn-buy" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#checkoutModal_{{ $p['id'] }}"
                                            >
                                        🛒 Beli Produk
                                    </button>
                                    
                                </td>
                                <!-- Modal Checkout Transaksi -->
                                <div class="modal fade" id="checkoutModal_{{ $p['id'] }}" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('products.checkout') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $p['id'] }}" id="modal_product_id">
                                                <div class="modal-header text-white" style="background-color: #0E7490;">
                                                    <h5 class="modal-title fw-bold" id="checkoutModalLabel">Form Transaksi Pembelian</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label font-semibold">Nama Produk API</label>
                                                        <input type="text" id="modal_product_title" value="{{ $p['title'] }}" class="form-control bg-light" readonly>
                                                        <p class="text text-danger" id="modal_product_sku">{{ $p['sku'] }}</p>
                                                        <p class="text text-info" id="modal_product_description">{{ $p['description'] }}</p>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Harga Asli</label>
                                                            <input type="text" id="modal_product_price" value="{{ $p['price'] }}" class="form-control bg-light" readonly>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Diskon API (%)</label>
                                                            <input type="text" id="modal_product_discount" value="{{ $p['discountPercentage'] }}" class="form-control bg-light" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nama Pembeli / Customer</label>
                                                        <input type="text" name="customer_name" class="form-control" placeholder="Masukkan nama Anda" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Jumlah Beli (Qty)</label>
                                                        <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success fw-bold">Proses Checkout & Bayar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Checkout Transaksi -->
{{-- <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('products.checkout') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="modal_product_id">
                <div class="modal-header text-white" style="background-color: #0E7490;">
                    <h5 class="modal-title fw-bold" id="checkoutModalLabel">Form Transaksi Pembelian</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label font-semibold">Nama Produk API</label>
                        <input type="text" id="modal_product_title" class="form-control bg-light" readonly>
                        <p class="text text-danger" id="modal_product_sku"></p>
                        <p class="text text-info" id="modal_product_description"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga Asli</label>
                            <input type="text" id="modal_product_price" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Diskon API (%)</label>
                            <input type="text" id="modal_product_discount" class="form-control bg-light" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pembeli / Customer</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Beli (Qty)</label>
                        <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold">Proses Checkout & Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            "language": { "sSearch": "Cari Produk API:" }
        });

        // Passing data produk dari tombol ke modal checkout
        // $('.btn-buy').click(function() {
        //     // Value
        //     $('#modal_product_id').val($(this).data('id'));
        //     $('#modal_product_title').val($(this).data('title'));
        //     $('#modal_product_price').val('$' + $(this).data('price'));
        //     $('#modal_product_discount').val($(this).data('discount') + '%');

        //     // Para
        //     const product_sku = document.getElementById("modal_product_sku");
        //     product_sku.innerHTML = '*' + $(this).data('sku');
        //     const product_description = document.getElementById("modal_product_description");
        //     product_description.innerHTML = '*' + $(this).data('description');
        // });
    });
</script>

@endpush