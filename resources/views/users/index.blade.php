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

                    {{-- <table class="table"> --}}
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <!-- Tombol Aksi (Edit, Hapus, dll) -->
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger"data-bs-toggle="modal" data-bs-target="#delete_<?= $user->id ?>">Hapus</button>
                                        <!-- Vertically centered Modal Delete -->
                                        <div class="modal fade" id="delete_<?= $user->id ?>" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                <h5 class="modal-title mb-3">Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                <p>
                                                    <i style="color: red" class="icon-base bx bx-alarm-exclamation bx-lg"></i>
                                                </p>
                                                <h5>Apakah Anda Yakin?</h5>
                                            <p>Data <b><?= $user->name ?></b> yang akan dihapus, tidak dapat dikembalikan!</p>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">❌ Tutup</a>
                                                        <button type="submit" name="delete" id="delete" value="Delete" class="btn btn-danger">🗑️ Ya, Hapus!</button>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div><!-- End Vertically centered Modal-->
                                        {{-- <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                                        </form> --}}
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
    new DataTable('#myTable', {});
</script>
@endpush
