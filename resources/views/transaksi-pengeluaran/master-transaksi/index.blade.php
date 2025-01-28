@extends('layouts.master')

@section('title','Master Transaksi')

@section('content')
<h1 class="my-4">@section('title_menu', 'Data Master Transaksi')</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="d-flex justify-content-between my-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">Tambah Data</button>
</div>

<table class="table table-bordered" id="master_transaksi">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Transaksi</th>
            <th>Type</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($master_transaksi as $list)
        <tr>
            <td>{{ $loop->iteration ?? '-' }}</td>
            <td>{{ $list->nama_transaksi }}</td>
            <td>{{ $list->type }}</td>
            <td>{{ $list->keterangan }}</td>
            <td>
                <button type="button" class="btn btn-warning btn-sm edit" id="{{ $list->id }}" data-toggle="modal" data-target="#EditData">
                    Edit
                </button>

                <form action="/delete-master-transaksi/{{ $list->id }}" method="get" class="d-inline">
                    @csrf
                    <button class="btn bg-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
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
                <h5 class="modal-title" id="tambahDataLabel">Tambah Data Master</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('master-index-store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_transaksi" class="form-label">Nama Transaksi</label>
                        <input type="text" class="form-control" id="nama_transaksi" name="nama_transaksi" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type" name="type" required>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>
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

<!-- Modal Edit-->
<div class="modal fade" id="EditData" tabindex="-1" aria-labelledby="EditDataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditDataLabel">Edit Data Master</h5>
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
                        <label for="nama_transaksi" class="form-label">Nama Transaksi</label>
                        <input type="text" class="form-control" id="nama_transaksi_edit" name="nama_transaksi" required>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" id="type_edit" name="type" required>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan_edit" name="keterangan" required>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" id="save" class="btn btn-primary">Simpan</button>
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
        $('#master_transaksi').DataTable({
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
        edits()
    });

    $(document).on('click', '.edit', function() {
        let id = $(this).attr('id')
        
        $.ajax({
            url: "{{ route('master-index-edit') }}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                // console.log(res)
                $('#id').val(res.data.id)
                $('#nama_transaksi_edit').val(res.data.nama_transaksi)
                $('#type_edit').val(res.data.type)
                $('#keterangan_edit').val(res.data.keterangan)
            }
        })
    });

    function edits()
    {
        var spinner = '<div class="spinner-border spinner-border-sm text-light" role="status"></div>  Loading...'
        $("#save").html(spinner);
        $.ajax({
            url: "{{ route('master-index-update') }}",
            type: "post",
            data: {
                id: $('#id').val(),
                nama_transaksi : $('#nama_transaksi_edit').val(),
                type : $('#type_edit').val(),
                keterangan : $('#keterangan_edit').val(),
                "_token": "{{ csrf_token() }}"
            },
            success: function(res) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: res.message,
                    showConfirmButton: false,
                    timer: 1500
                })
                location.reload();
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message)
                $('#close').click()
            }
        })
    };
</script>
@endsection