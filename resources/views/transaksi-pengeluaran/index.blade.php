@extends('layouts.master')

@section('title','TRANSAKSI')

@section('content')
<h1 class="my-4">@section('title_menu', 'Transaksi Pengeluaran')</h1>

<div class="row">
    <div class="col-lg-3 col-6">
        <a href="/master-transaksi">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3></h3>
                    <p>Data Master Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="small-box-footer"><i class="fas fa-ellipsis-h"></i></div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="/transaksi-pengeluaran">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3></h3>
                    
                    <p>Transaksi Pengeluaran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check"></i>
                </div>
                <div class="small-box-footer"><i class="fas fa-ellipsis-h"></i></div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="/transaksi-pengeluaran-barang">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3></h3>
                    
                    <p>Transaksi Barang Keluar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-store-slash"></i>
                </div>
                <div class="small-box-footer"><i class="fas fa-ellipsis-h"></i></div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="/laporan-pengeluaran-index">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3></h3>
                    
                    <p>Laporan Pengeluaran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="small-box-footer"><i class="fas fa-ellipsis-h"></i></div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-6">
        <a href="/laporan-pengeluaran-barang-index">
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3></h3>
                    
                    <p class="text-white">Laporan Barang Keluar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-folder-minus"></i>
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
        $('#transaksi_pengeluaran').addClass('active')
    });
</script>
@endsection
