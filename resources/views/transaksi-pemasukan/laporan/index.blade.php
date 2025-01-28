@extends('layouts.master')

@section('title', 'Laporan Pemasukan')
@section('content')

<form method="GET" action="{{ route('laporan.pemasukan') }}">
    <label for="filter">Filter Berdasarkan:</label>
    <select class="form-control" name="filter" id="filter">
        <option value="harian" {{ request('filter', 'harian') == 'harian' ? 'selected' : '' }}>Harian</option>
        <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
        <option value="tahunan" {{ request('filter') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
    </select>

    <br>
    <label for="tanggal">Tanggal (YYYY-MM-DD):</label>
    <input class="form-control" type="text" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
        placeholder="Masukkan tanggal" />

    <div class="d-flex justify-content-end">
        <button class="btn btn-secondary mb-3 mt-2 mr-2"  onclick="resetForm()">Reset</button>
        <button class="btn btn-success mb-3 mt-2" type="submit">Filter</button>
    </div>
</form>

<button class="btn btn-info mb-3" onclick="openPrintWindow()">Print Laporan</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Jumlah Pemasukan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pemasukan as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ number_format($item->jumlah, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
    <!-- Menampilkan total pemasukan di bawah tabel -->
    <tfoot>
        <tr class="total-row">
            <td colspan="3" class="text-bold text-center text-primary">Total Pemasukan</td>
            <td class="text-bold text-danger">{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#transaksi_pemasukan').addClass('active')
    });

    function openPrintWindow() {
        // Membuka halaman baru untuk mencetak
        var printWindow = window.open('', '', 'width=800, height=600');

        // Menyisipkan HTML untuk tampilan yang akan dicetak
        printWindow.document.write('<html><head><title>Laporan Pemasukan</title>');

        // Menambahkan CSS untuk mencetak agar tampilan sesuai
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: Arial, sans-serif; font-size: 14px; }');
        printWindow.document.write('.table { width: 100%; border-collapse: collapse; }');
        printWindow.document.write(
        '.table th, .table td { border: 1px solid #000; padding: 8px; text-align: center; }');
        printWindow.document.write('.total-row { font-weight: bold; }');
        printWindow.document.write('</style>');

        printWindow.document.write('</head><body>');
        printWindow.document.write('<h1>Laporan Pemasukan</h1>');
        printWindow.document.write('<table class="table" border="1" cellpadding="8" cellspacing="0">');
        printWindow.document.write(
            '<thead><tr><th>No</th><th>Nama Barang</th><th>Tanggal</th><th>Jumlah Pemasukan</th></tr></thead><tbody>');

        @foreach ($pemasukan as $item)
            printWindow.document.write(
                '<tr><td>{{ $loop->iteration }}</td><td>{{ $item->barang->nama_barang }}</td><td>{{ $item->tanggal }}</td><td>{{ number_format($item->jumlah, 0, ',', '.') }}</td></tr>'
                );
        @endforeach

        printWindow.document.write('</tbody><tfoot>');
        printWindow.document.write(
            '<tr class="total-row"><td colspan="3">Total Pemasukan</td><td>{{ number_format($totalPemasukan, 0, ',', '.') }}</td></tr>'
            );
        printWindow.document.write('</tfoot></table>');
        printWindow.document.write('</body></html>');

        // Menunggu beberapa detik agar halaman selesai dimuat sebelum mencetak
        printWindow.document.close();
        printWindow.print();
    }

    function resetForm() {
        // Reset input tanggal dan filter
        document.getElementById('tanggal').value = '';
        document.getElementById('filter').value = 'harian'; // Kembalikan ke 'harian' sebagai default
    }
</script>
@endsection
