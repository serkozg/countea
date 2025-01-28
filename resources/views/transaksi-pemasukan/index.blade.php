@extends('layouts.master')

@section('title','TRANSAKSI PEMASUKAN')

@section('content')
<h1 class="my-4">@section('title_menu', 'Transaksi Pemasukan')</h1>

<div class="row">
    {{-- <div class="col-lg-3 col-6">
        <a href="/transaksi-pemasukan">
            <div class="small-box bg-pink">
                <div class="inner">
                    <h3></h3>
                    <p>Transaksi Pemasukan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="small-box-footer"><i class="fas fa-ellipsis-h"></i></div>
            </div>
        </a>
    </div> --}}
    <div class="col-lg-3 col-6">
        <a href="/transaksi-pemasukan">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3></h3>
                    <p>Transaksi Barang Masuk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="small-box-footer"><i class="fas fa-ellipsis-h"></i></div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="/laporan-pemasukan-index">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3></h3>
                    <p>Laporan Pemasukan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="small-box-footer"><i class="fas fa-ellipsis-h"></i></div>
            </div>
        </a>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#transaksi_pemasukan').addClass('active')
    });
</script>
@endsection
