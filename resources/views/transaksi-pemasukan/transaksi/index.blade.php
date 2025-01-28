@extends('layouts.master')

@section('title','Transaksi Pemasukan')

@section('content')
{{-- <h1 class="my-4">@section('title_menu', 'Pemasukan')</h1> --}}

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between my-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">Tambah Pemasukan</button>
</div>

<table class="table table-bordered" id="table_pemasukan">
    <thead>
        <tr>
            <th>#</th>
            <th>No Pemasukan</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Faktur</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksi_pemasukan as $transaksi)
        <tr>
            <td>{{ $loop->iteration ?? '-' }}</td>
            <td>{{ $transaksi->no_pemasukan }}</td>
            <td>{{ $transaksi->barang->nama_barang }}</td>
            <td>{{ $transaksi->tanggal }}</td>
            <td>
                @if ($transaksi->image)
                <a href="{{ asset('images/pemasukan/' . $transaksi->image) }}" target="_blank" class="btn btn-default btn-sm">
                    <i class="fas fa-file"></i>
                </a>
                @else
                -
                {{-- <span>No image</span> --}}
                @endif
            </td>
            <td>{{ $transaksi->jumlah ?? '-' }}</td>
            <td>
                <form action="/delete-transaksi-pemasukan/{{ $transaksi->id }}" method="get" class="d-inline">
                    @csrf
                    <button class="btn bg-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus transaksi ini?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Tambah-->
<div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataLabel">Tambah Data Barang Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pemasukan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="no_pemasukan" class="form-label">Nomor Pemasukan</label>
                        <input type="text" class="form-control" id="no_pemasukan" name="no_pemasukan" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="barang">Select Barang</label>
                        <select class="form-control" name="barang_id" id="barang_id">
                            @foreach($data_barang as $barangItem)
                            <option value="{{ $barangItem->id }}">{{ $barangItem->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah">
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#transaksi_pemasukan').addClass('active')
    });

    $(function() {
        $('#table_pemasukan').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "select_all": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endsection