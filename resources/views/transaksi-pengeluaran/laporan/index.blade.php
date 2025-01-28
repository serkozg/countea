@extends('layouts.master')

@section('title', 'Laporan Barang Keluar')

@section('content')

<form method="GET" action="{{ route('laporan.pengeluaran') }}">
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
        <button class="btn btn-secondary mb-3 mt-2 mr-2" type="reset" onclick="resetForm()">Reset</button>
        <button class="btn btn-success mb-3 mt-2" type="submit">Filter</button>
    </div>
</form>

<button class="btn btn-info mb-3" onclick="openPrintWindow()">Print Laporan</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Pengeluaran</th>
            <th>Nama Transaksi</th>
            <th>No. Bukti</th>
            <th>Keterangan</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengeluarans as $pengeluaran)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pengeluaran->tgl_pengeluaran }}</td>
                <td>{{ $pengeluaran->mtransaksi->nama_transaksi }}</td>
                <td>{{ $pengeluaran->no_bukti }}</td>
                <td>{{ $pengeluaran->keterangan }}</td>
                <td>Rp {{ number_format((float)str_replace('.', '', $pengeluaran->total), 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr class="total-row">
            <td colspan="5" class="text-bold text-center text-primary">Total Keseluruhan</td>
            <td class="text-bold text-danger">Rp {{ $totalKeseluruhan }}</td>
        </tr>
    </tfoot>
</table>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#transaksi_pengeluaran').addClass('active');
    });

    function openPrintWindow() {
        var printWindow = window.open('', '', 'width=800, height=600');
        printWindow.document.write('<html><head><title>Laporan Pengeluaran</title>');
        printWindow.document.write('<style> body { font-family: Arial, sans-serif; font-size: 14px; } .table { width: 100%; border-collapse: collapse; } .table th, .table td { border: 1px solid #000; padding: 8px; text-align: center; } .total-row { font-weight: bold; }</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h1>Laporan Pengeluaran</h1>');
        printWindow.document.write('<table class="table" border="1" cellpadding="8" cellspacing="0">');
        printWindow.document.write('<thead><tr><th>No</th><th>Tanggal</th><th>Nama Transaksi</th><th>No. Bukti</th><th>Keterangan</th><th>Total</th></tr></thead><tbody>');
        
        @foreach ($pengeluarans as $pengeluaran)
            printWindow.document.write('<tr><td>{{ $loop->iteration }}</td><td>{{ $pengeluaran->tgl_pengeluaran }}</td><td>{{ $pengeluaran->mtransaksi->nama_transaksi }}</td><td>{{ $pengeluaran->no_bukti }}</td><td>{{ $pengeluaran->keterangan }}</td><td>Rp {{ number_format((float)str_replace('.', '', $pengeluaran->total), 0, ',', '.') }}</td></tr>');
        @endforeach

        printWindow.document.write('</tbody><tfoot><tr class="total-row"><td colspan="5">Total Keseluruhan</td><td>Rp {{ $totalKeseluruhan }}</td></tr></tfoot></table>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    function resetForm() {
        document.getElementById('tanggal').value = '';
        document.getElementById('filter').value = 'harian';
    }
</script>
@endsection

