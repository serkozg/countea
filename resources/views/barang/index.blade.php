@extends('layouts.master')

@section('title', 'BARANG')

@section('content')
    <h1 class="my-4">
    @section('title_menu', 'Daftar Barang')
</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between my-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahBarangModal">Tambah
        Barang</button>
</div>

<table class="table table-bordered" id="table_barang">
    <thead>
        <tr>
            <th>#</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Type</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $barang)
            <tr>
                <td>{{ $loop->iteration ?? '-' }}</td>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ $barang->kategori }}</td>
                <td>{{ $barang->type == 1 ? 'Standar' : 'Inventori' }}</td>
                <td>{{ $barang->harga_beli }}</td>
                <td>{{ $barang->harga_jual }}</td>
                <td>
                    @if ($barang->stok <= $barang->stok_min)
                        <span class="text-bold text-danger">{{ $barang->stok }}</span> <br> <span><small>Stok Minimum :
                                {{ $barang->stok_min }}</small></span>
                    @else
                        <span class="text-bold text-primary">{{ $barang->stok }}</span> <br> <span><small>Stok Minimum
                                : {{ $barang->stok_min }}</small></span>
                    @endif
                </td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm edit" id="{{ $barang->id }}"
                        data-toggle="modal" data-target="#editBarangModal">
                        Edit
                    </button>

                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>



<!-- Modal Tambah Barang -->
<div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBarangModalLabel">Tambah Barang Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('barang.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori">
                    </div>

                    <div class="form-group">
                        <label>Select</label>
                        <select class="form-control" name="type">
                            <option value="1">Standard</option>
                            <option value="2">Inventori</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="text" class="form-control" id="harga_beli" name="harga_beli" required
                            oninput="formatRupiah(this)">
                    </div>

                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" required
                            oninput="formatRupiah(this)">
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
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

<!-- Modal Edit Barang -->
<div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="editBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang_edit" name="kode_barang"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang_edit" name="nama_barang"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="kategori_edit" name="kategori">
                    </div>

                    <div class="form-group">
                        <label>Select</label>
                        <select class="form-control" name="type_edit" id="type_edit">
                            <option value="1">Standard</option>
                            <option value="2">Inventori</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="harga_beli" class="form-label">Harga Beli</label>
                        <input type="text" class="form-control" id="harga_beli_edit" name="harga_beli" required
                            oninput="formatRupiah(this)">
                    </div>

                    <div class="mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <input type="text" class="form-control" id="harga_jual_edit" name="harga_jual" required
                            oninput="formatRupiah(this)">
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok_edit" name="stok" required>
                    </div>

                    <div class="mb-3">
                        <label for="stok_min" class="form-label">Stok Minimum</label>
                        <input type="number" class="form-control" id="stok_min_edit" name="stok_min">
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="button" id="save" class="btn btn-primary">Update</button>
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
        $('#master_barang').addClass('active')
    });

    $(function() {
        $('#table_barang').DataTable({
            "paging": true,
            "lengthChange": false,
            "ordering": true,
            "select_all": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    $('#save').on('click', function() {
        // console.log('Hi')
        edits()
    });

    $(document).on('click', '.edit', function() {
        let id = $(this).attr('id')

        $.ajax({
            url: "{{ route('get.edit-data-barang') }}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                // console.log(res)
                $('#id').val(res.data.id)
                $('#kode_barang_edit').val(res.data.kode_barang)
                $('#nama_barang_edit').val(res.data.nama_barang)
                $('#kategori_edit').val(res.data.kategori)
                $('#harga_beli_edit').val(res.data.harga_beli)
                $('#harga_jual_edit').val(res.data.harga_jual)
                $('#stok_edit').val(res.data.stok)
                $('#stok_min_edit').val(res.data.stok_min)
                $('#type_edit').val(res.data.type)
            }
        })
    });

    function edits() {
        var spinner = '<div class="spinner-border spinner-border-sm text-light" role="status"></div>  Loading...'
        $("#save").html(spinner);
        $.ajax({
            url: "{{ route('get.update-data-barang') }}",
            type: "post",
            data: {
                id: $('#id').val(),
                kode_barang: $('#kode_barang_edit').val(),
                nama_barang: $('#nama_barang_edit').val(),
                kategori: $('#kategori_edit').val(),
                type: $('#type_edit').val(),
                harga_beli: $('#harga_beli_edit').val(),
                harga_jual: $('#harga_jual_edit').val(),
                stok: $('#stok_edit').val(),
                stok_min: $('#stok_min_edit').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(res) {
                // console.log(res.data);
                // alert(res.text)
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500
                })
                // $('#close').click()
                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message)
                $('#close').click()
            }
        })
    };

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
