@extends('layouts.master')

@section('title','Transaksi Pengeluaran')

@section('content')
{{-- <h1 class="my-4">@section('title_menu', 'Pengeluaran')</h1> --}}

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between my-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">Tambah Pengeluaran</button>
</div>

<table class="table table-bordered" id="table_pengeluaran">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal Pengeluaran</th>
            <th>Nama Transaksi Pengeluaran</th>
            <th>Type</th>
            <th>No Bukti Pengeluaran</th>
            <th>Keterangan</th>
            <th>Total Pengeluaran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksi_pengeluaran as $transaksi)
        <tr>
            <td>{{ $loop->iteration ?? '-' }}</td>
            <td>{{ $transaksi->tgl_pengeluaran ?? '-' }}</td>
            <td>{{ $transaksi->mtransaksi->nama_transaksi ?? '-' }}</td>
            <td>{{ $transaksi->mtransaksi->type ?? '-' }}</td>
            <td>{{ $transaksi->no_bukti ?? '-' }}</td>
            <td>{{ $transaksi->keterangan ?? '-' }}</td>
            <td>{{ $transaksi->total }}</td>
            {{-- <td>{{ number_format($transaksi->jumlah, 0, ',', '.') ?? '-' }}</td> --}}
            <td>
                <form action="/delete-transaksi-pengeluaran/{{ $transaksi->id }}" method="get" class="d-inline">
                    @csrf
                    <button class="btn bg-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus transaksi ini?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>

                @if ($transaksi->image)
                <a href="{{ asset('images/pengeluaran/' . $transaksi->image) }}" target="_blank" class="btn btn-default btn-sm">
                    <i class="fas fa-file"></i>
                </a>
                @else
                {{-- <span>No image</span> --}}
                @endif
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
                <h5 class="modal-title" id="tambahDataLabel">Tambah Data Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="tgl_pengeluaran" class="form-label">Tanggal Pengeluaran</label>
                        <input type="date" class="form-control" id="tgl_pengeluaran" name="tgl_pengeluaran" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="mtransaksi">Transaksi</label>
                        <select class="form-control" name="mtransaksi_id" id="mtransaksi_id">
                            @foreach($master_transaksi as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_transaksi }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="no_bukti" class="form-label">Nomor Bukti</label>
                        <input type="text" class="form-control" id="no_bukti" name="no_bukti">
                    </div>

                    <div class="mb-3">
                        <label for="total" class="form-label">Total</label>
                        <input type="text" class="form-control" id="total" name="total" required oninput="formatRupiah(this)">
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="5"></textarea>
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
        $('#transaksi_pengeluaran').addClass('active')
    });

    $(function() {
        $('#table_pengeluaran').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    // Fungsi untuk memformat input menjadi format rupiah
    function formatRupiah(input) {
        // Ambil nilai input
        let value = input.value;
        
        // Menghapus karakter selain angka
        value = value.replace(/[^\d]/g, "");
        
        // Menambahkan pemisah ribuan (titik) pada angka
        if (value) {
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        
        // Menampilkan format yang sudah diubah
        input.value = value;
    }
    
    // Fungsi untuk mengambil nilai tanpa format (angka saja) saat form dikirim
    function getNumericValue() {
        let hargaBeli = document.getElementById("harga_beli").value;
        // Menghapus titik yang digunakan sebagai pemisah ribuan
        return hargaBeli.replace(/[^\d]/g, "");
    }
    
    // Jika form akan dikirim, pastikan untuk mengambil nilai numerik
    document.querySelector("form").onsubmit = function() {
        let hargaBeliInput = document.getElementById("harga_beli");
        // Ambil nilai numerik dan set ulang nilai input
        hargaBeliInput.value = getNumericValue();
    };
</script>
@endsection