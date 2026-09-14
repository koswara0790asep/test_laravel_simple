@extends('layouts.master')

@section('title', 'Riwayat Aktivitas')

@section('content')


<div class="container mb-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold text-dark">Riwayat Activity & Login System</h5>
            @if (Auth::user()->role === "staff")
                <form action="{{ route('log_activities.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SELURUH riwayat log?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Bersihkan All Log</button>
                </form>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="logTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th width="40">No</th>
                            <th>Pengguna</th>
                            <th>Aktivitas (Subject)</th>
                            <th>URL & Method</th>
                            <th>Alamat IP</th>
                            <th>Browser / Agent</th>
                            <th>Waktu Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $index => $log)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($log->user)
                                        <span class="fw-semibold text-primary">{{ $log->user->name }}</span><br>
                                        <small class="text-muted">{{ $log->user->email }}</small>
                                    @else
                                        <span class="badge bg-secondary">Tamu / Guest</span>
                                    @endif
                                </td>
                                <td>
                                    @if(str_contains($log->subject, 'Berhasil'))
                                        <span class="badge bg-success">{{ $log->subject }}</span>
                                    @elseif(str_contains($log->subject, 'Gagal'))
                                        <span class="badge bg-danger">{{ $log->subject }}</span>
                                    @else
                                        <span class="badge bg-info text-dark">{{ $log->subject }}</span>
                                    @endif
                                </td>
                                <td>
                                    <small><span class="badge bg-{{ $log->method === 'GET' ? 'primary' : ($log->method === 'POST' ? 'success' : ($log->method === 'PUT' ? 'warning' : 'danger')) }} border">{{ $log->method }}</span> <a href="{{ $log->url }}{{ $log->method === 'PUT' ? '/edit' : '' }}" class="text text-black">{{ $log->url }}{{ $log->method === 'PUT' ? '/edit' : '' }} ➡️</a></small>
                                </td>
                                <td><span class="badge bg-dark">{{ $log->ip_address }}</span></td>
                                <td><small class="text-muted">{{ Str::limit($log->agent, 40) }}</small></td>
                                @php
                                    $localDateTime = \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Jakarta');
                                @endphp
                                <td><small class="fw-bold">{{ $localDateTime }}</small></td>
                            </tr>
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
        $('#logTable').DataTable({
            "order": [[ 6, "desc" ]], // Urutkan berdasarkan waktu paling baru
            "language": {
                "sSearch": "Cari Log:",
                "sLengthMenu": "Tampilkan _MENU_ data log",
                "sInfo": "Menampilkan _START_ - _END_ dari total _TOTAL_ log"
            }
        });
    });
</script>

@endpush