@extends('layouts.master')

@section('title', 'Data Siswa')

@section('content')
    <!-- ================= TABLE / DATATABLE PAGE ================= -->
    <div class="card">
      <h5 class="card-header">Data Siswa</h5>
      <div class="table-responsive text-nowrap p-4">
        <table id="myTable" class="table">
          <thead>
            <tr class="text-nowrap">
              <th>#</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Jhon Doe</td>
              <td>XII - RPL - A</td>
              <td><span class="badge bg-label-success">Aktif</span></td>
              <td>
                <a href="#" class="btn btn-sm btn-warning">✏️</a>
                <form action="#" method="POST" style="display: inline-block;">
                  <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                </form>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jane Doe</td>
              <td>XII - RPL - A</td>
              <td><span class="badge bg-label-success">Aktif</span></td>
              <td>
                <a href="#" class="btn btn-sm btn-warning">✏️</a>
                <form action="#" method="POST" style="display: inline-block;">
                  <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                </form>
              </td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Fulan</td>
              <td>XII - RPL - A</td>
              <td><span class="badge bg-label-success">Aktif</span></td>
              <td>
                <a href="#" class="btn btn-sm btn-warning">✏️</a>
                <form action="#" method="POST" style="display: inline-block;">
                  <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
@endsection

@push('scripts')
  <script> 
    $(document).ready(function() {
      $('#myTable').DataTable({

      })
    })
  </script> 
@endpush 