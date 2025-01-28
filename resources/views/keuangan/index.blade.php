@extends('layouts.master')

@section('title', 'KEUANGAN')

@section('content')
    {{-- <h1 class="my-4">@section('title_menu', '')</h1> --}}

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between my-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahData">Tambah Data</button>
    </div>

    <table class="table table-bordered" id="table_keuangan">
        <thead>
            <tr>
                <th>No</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Tanggal</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Tanggal Pelunasan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keuangan as $item)
                <tr>
                    <td>{{ $loop->iteration ?? '-' }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->nominal }}</td>
                    <td>{{ $item->tgl }}</td>
                    <td>{{ $item->tgl_tempo }}</td>
                    <td>{{ $item->tgl_pelunasan ?? '-' }}</td>
                    <td>
                        @if ($item->status == 1)
                            <span class="badge badge-danger">Belum Dibayar</span>
                        @elseif ($item->status == 2)
                            <span class="badge badge-success">Sudah Pelunasan</span>
                        @else
                            <span class="badge badge-secondary">Belum ada status</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->status == 1)
                            <button type="button" class="btn btn-warning btn-sm edit" id="{{ $item->id }}"
                                data-toggle="modal" data-target="#editData">
                                <i class="fas fa-edit"></i>
                            </button>
                        @else
                        @endif

                        @if ($item->image)
                            <a href="{{ asset('images/keuangan/' . $item->image) }}" target="_blank"
                                class="btn btn-default btn-sm">
                                <i class="fas fa-file"></i>
                            </a>
                        @else
                            <button type="button" class="btn btn-dark btn-sm edit" id="{{ $item->id }}"
                                data-toggle="modal" data-target="#editImage">
                                <i class="fas fa-upload"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="status" id="status" value="1">
                        <div class="mb-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="5"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="text" class="form-control" id="nominal" name="nominal" required
                                oninput="formatRupiah(this)">
                        </div>

                        <div class="mb-3">
                            <label for="tgl" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tgl" name="tgl" required>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                            <input type="date" class="form-control" id="tgl_tempo" name="tgl_tempo" required>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="editData" tabindex="-1" aria-labelledby="editDataLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDataLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan_edit" rows="5" disabled></textarea>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="id" id="id" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="text" class="form-control" id="nominal_edit" name="nominal" required
                                oninput="formatRupiah(this)" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_pelunasan" class="form-label">Tanggal Pelunasan</label>
                            <input type="date" class="form-control" id="tgl_pelunasan_edit" name="tgl_pelunasan"
                                required>
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

    <!-- Modal Edit Image-->
    <div class="modal fade" id="editImage" tabindex="-1" aria-labelledby="editImageLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editImageLabel">Edit Data Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <input type="hidden" name="id" id="id" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image_edit" name="image">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="button" id="imagesave" class="btn btn-primary">Simpan</button>
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
            $('#keuangan').addClass('active')
        });

        $(function() {
            $('#table_keuangan').DataTable({
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

        $('#imagesave').on('click', function() {
            imagedit()
        });

        $(document).on('click', '.edit', function() {
            let id = $(this).attr('id')

            $.ajax({
                url: "{{ route('get.edit-keuangan') }}",
                type: 'post',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $('#id').val(res.data.id)
                    $('#keterangan_edit').val(res.data.keterangan)
                    $('#nominal_edit').val(res.data.nominal)
                }
            })
        });

        function edits() {
            var spinner = '<div class="spinner-border spinner-border-sm text-light" role="status"></div>  Loading...'
            $("#save").html(spinner);
            $.ajax({
                url: "{{ route('get.update-keuangan') }}",
                type: "post",
                data: {
                    id: $('#id').val(),
                    tgl_pelunasan: $('#tgl_pelunasan_edit').val(),
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

        function imagedit() {
            var spinner = '<div class="spinner-border spinner-border-sm text-light" role="status"></div>  Loading...'
            $("#imagesave").html(spinner);

            var formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('image', $('#image_edit')[0].files[0]); // Mengambil file yang dipilih
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('get.update-keuangan-image') }}",
                type: "post",
                data: formData,
                processData: false, // Jangan proses data menjadi query string
                contentType: false, // Jangan set content-type (karena menggunakan FormData)
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
                    alert(xhr.responseJSON.message);
                    $('#close').click();
                }
            });
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
