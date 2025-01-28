<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\TransaksiPemasukan;
use App\Models\TransaksiPengeluaran;
use App\Models\TransaksiPengeluaranBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
   public function index()
   {
      //Dashboard Pemasukan
      $today           = Carbon::today();
      $dailyTotal      = TransaksiPemasukan::with('barang')->whereDate('tanggal', $today)->sum('jumlah');
      $daily           = TransaksiPemasukan::with('barang')->whereDate('tanggal', $today)->get();
      $totalPerH       = $daily->sum(function ($transaksi) {
         return $transaksi->jumlah * (int) str_replace('.', '',$transaksi->barang->harga_jual);
      });

      $currentMonth    = Carbon::now()->month;
      $monthlyTotal    = TransaksiPemasukan::whereMonth('tanggal', $currentMonth)->sum('jumlah');
      $monthly         = TransaksiPemasukan::with('barang')->whereMonth('tanggal', $currentMonth)->get();
      $totalPerB       = $monthly->sum(function ($transaksi) {
         return $transaksi->jumlah * (int) str_replace('.', '',$transaksi->barang->harga_jual);
      });

      $currentYears    = Carbon::now()->year;
      $yearsTotal      = TransaksiPemasukan::whereYear('tanggal', $currentYears)->sum('jumlah');
      $years           = TransaksiPemasukan::with('barang')->whereYear('tanggal', $currentYears)->get();
      $totalPerT       = $years->sum(function ($transaksi) {
         return $transaksi->jumlah * (int) str_replace('.', '',$transaksi->barang->harga_jual);
      });

      //Dashboard Pengeluaran
      //D
      $today           = Carbon::today();
      $dailyTotalOut   = TransaksiPengeluaranBarang::whereDate('tanggal', $today)->sum('jumlah');
      
      $dailyOutB       = TransaksiPengeluaranBarang::with('barang')->whereDate('tanggal', $today)->get();
      $totalOutPerHB      = $dailyOutB->sum(function ($transaksi) {
         return $transaksi->jumlah * (int) str_replace('.', '',$transaksi->barang->harga_jual);
      });

      $dailyOut       = TransaksiPengeluaran::whereDate('tgl_pengeluaran', $today)->get();
      $totalOutPerH   = $dailyOut->sum(function ($transaksi) {
         return (int)str_replace('.', '', $transaksi->total);
     });

     $todayOut       = $totalOutPerHB + $totalOutPerH;

     //M
      $currentMonth    = Carbon::now()->month;
      $monthlyTotalOut = TransaksiPengeluaranBarang::whereMonth('tanggal', $currentMonth)->sum('jumlah');

      $monthlyOutB     = TransaksiPengeluaranBarang::with('barang')->whereMonth('tanggal', $currentMonth)->get();
      $totalOutPerMB   = $monthlyOutB->sum(function ($transaksi) {
         return $transaksi->jumlah * (int) str_replace('.', '',$transaksi->barang->harga_jual);
      });

      $monthlyOut       = TransaksiPengeluaran::whereMonth('tgl_pengeluaran', $currentMonth)->get();
      $totalOutPerM     = $monthlyOut->sum(function ($transaksi) {
         return (int)str_replace('.', '', $transaksi->total);
     });

     $monthlyOuts       = $totalOutPerMB + $totalOutPerM;

     //Y
      $currentYears    = Carbon::now()->year;
      $yearsTotalOut   = TransaksiPengeluaranBarang::whereYear('tanggal', $currentYears)->sum('jumlah');

      $yearsOutB       = TransaksiPengeluaranBarang::with('barang')->whereYear('tanggal', $currentYears)->get();
      $totalOutPerYB   = $yearsOutB->sum(function ($transaksi) {
         return $transaksi->jumlah * (int) str_replace('.', '',$transaksi->barang->harga_jual);
      });

      $yearsOut       = TransaksiPengeluaran::whereYear('tgl_pengeluaran', $currentYears)->get();
      $totalOutPerY   = $yearsOut->sum(function ($transaksi) {
         return (int)str_replace('.', '', $transaksi->total);
     });

     $yearsOuts       = $totalOutPerYB + $totalOutPerY;


      $tglJatuhTempo   = Keuangan::where('status', '1')->where('tgl_tempo', '<=', Carbon::now())->get();
      $totalTempo      = $tglJatuhTempo->sum(function($item) {
         return (int) str_replace('.', '', $item->nominal);
      });
      
      $tglBelumBayar   = Keuangan::where('status', '1')->whereMonth('tgl', Carbon::now()->month)->get();
      $totalNominal    = $tglBelumBayar->sum(function($item) {
         return (int) str_replace('.', '', $item->nominal);
      });

      $pembayaranLunas = Keuangan::where('status', '2')->whereMonth('tgl_pelunasan', Carbon::now()->month)->whereYear('tgl_pelunasan', Carbon::now()->year)->get();
      $totalPelunasan  = $pembayaranLunas->sum(function($item) {
         return (int) str_replace('.', '', $item->nominal);
      });

      return view('dashboard.index', 
      compact(
      'dailyTotal',
      'totalPerH',
      'monthlyTotal',
      'totalPerB',
      'yearsTotal',
      'totalPerT',
      'dailyTotalOut',
      'totalOutPerHB',
      'totalOutPerH',
      'todayOut',
      'monthlyTotalOut',
      'totalOutPerMB',
      'totalOutPerM',
      'monthlyOuts',
      'yearsTotalOut',
      'totalOutPerYB',
      'totalOutPerY',
      'yearsOuts',
      'totalTempo',
      'totalNominal',
      'totalPelunasan'));
   }
}
