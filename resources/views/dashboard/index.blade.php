@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #FF7f50">
                    <h3 class="card-title">Pembayaran Belum Dibayar (IDR)
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">Rp. {{ number_format($totalNominal, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #FF8c00">
                    <h3 class="card-title">Pembayaran Jatuh Tempo (IDR/D)
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">Rp. {{ number_format($totalTempo, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #FF4500">
                    <h3 class="card-title">Pelunasan (IDR/Y)
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">Rp. {{ number_format($totalPelunasan, 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #DA70D6">
                    <h3 class="card-title">Total Barang Masuk perHari
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">{{ $dailyTotal ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #FF00FF">
                    <h3 class="card-title">Total Barang Masuk perBulan
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">{{ $monthlyTotal }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #8a2be2">
                    <h3 class="card-title">Total Barang Masuk perTahun
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">{{ $yearsTotal }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #4169e1">
                    <h3 class="card-title">Total Barang Keluar perHari
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">{{ $dailyTotalOut }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color:#0000FF">
                    <h3 class="card-title">Total Barang Keluar perBulan
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">{{ $monthlyTotalOut }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #00008b">
                    <h3 class="card-title">Total Barang Keluar perTahun
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">{{ $yearsTotalOut }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #228b22">
                    <h3 class="card-title">Total Biaya Masuk perHari
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">Rp. {{ number_format($totalPerH, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #9acd32">
                    <h3 class="card-title">Total Biaya Masuk perBulan
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">Rp. {{ number_format($totalPerB, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #556b2f">
                    <h3 class="card-title">Total Biaya Masuk perTahun
                    </h3>
                </div>
                <div id="card-body" style="height: 50px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">Rp. {{ number_format($totalPerT, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #8b4513">
                    <h3 class="card-title">Total Biaya Keluar perHari
                    </h3>
                </div>
                <div id="card-body" style="height: 105px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">
                        Rp. {{ number_format($todayOut, 0, ',', '.') }} <br>
                        <small>[B : Rp. {{ number_format($totalOutPerHB, 0, ',', '.') }}]</small> <br>
                        <small>[U : Rp. {{ number_format($totalOutPerH, 0, ',', '.') }}]</small>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #a52a2a">
                    <h3 class="card-title">Total Biaya Keluar perBulan
                    </h3>
                </div>
                <div id="card-body" style="height: 105px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">
                        Rp. {{ number_format($monthlyOuts, 0, ',', '.') }} <br>
                        <small>[B : Rp. {{ number_format($totalOutPerMB, 0, ',', '.') }}]</small> <br>
                        <small>[U : Rp. {{ number_format($totalOutPerM, 0, ',', '.') }}]</small>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card card-dark">
                <div class="card-header" style="background-color: #800000">
                    <h3 class="card-title">Total Biaya Keluar perTahun
                    </h3>
                </div>
                <div id="card-body" style="height: 105px">
                    <h4 style="margin-left: 20px; margin-top: 10px;">
                        Rp. {{ number_format($yearsOuts, 0, ',', '.') }} <br>
                        <small>[B : Rp. {{ number_format($totalOutPerYB, 0, ',', '.') }}]</small> <br>
                        <small>[U : Rp. {{ number_format($totalOutPerY, 0, ',', '.') }}]</small>
                    </h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#dashboard').addClass('active')
        });
    </script>
@endsection
