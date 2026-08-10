@extends('layouts.master')

@section('title', 'Data User')

@section('content')

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">Data User</h5>
            <div class="table-responsive text-nowrap">
                <!-- Tambahkan ID 'myTable' pada tag table -->
                <div class="p-4">
                    <div class="btn btn-primary mb-4">
                        <a href="{{ route('users.create') }}" class="text-white text-decoration-none">Tambah User</a>
                    </div>

                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <!-- Tombol Aksi (Edit, Hapus, dll) -->
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables pada ID #myTable
        $('#myTable').DataTable({
            // Bahasa Indonesia untuk UI DataTables
            "language": {
                "sEmptyTable":   "Tidak ada data yang tersedia pada tabel ini",
                "sProcessing":   "Sedang memproses...",
                "sLengthMenu":   "Tampilkan _MENU_ entri",
                "sZeroRecords":  "Tidak ditemukan data yang sesuai",
                "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sSearch":       "Cari Data:",
                "oPaginate": {
                    "sFirst":    "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext":     "Selanjutnya",
                    "sLast":     "Terakhir"
                }
            }
        });
    });
</script>
@endpush
