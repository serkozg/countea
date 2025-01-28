<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPemasukan;
use App\Models\TransaksiPengeluaran;
use App\Models\TransaksiPengeluaranBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function laporan_pemasukan_index(Request $request)
    {
        $filter = $request->input('filter', 'harian'); // Default 'harian' jika tidak ada filter
        $tanggal = $request->input('tanggal'); // tanggal yang dipilih untuk filter
        
        $query = TransaksiPemasukan::query();
        
        // Filter berdasarkan harian, bulanan, atau tahunan
        if ($filter == 'harian') {
            $query->whereDate('tanggal', Carbon::parse($tanggal)->format('Y-m-d'));
        } elseif ($filter == 'bulanan') {
            $query->whereYear('tanggal', Carbon::parse($tanggal)->format('Y'))
            ->whereMonth('tanggal', Carbon::parse($tanggal)->format('m'));
        } elseif ($filter == 'tahunan') {
            $query->whereYear('tanggal', $tanggal);
        }
        
        // Ambil data transaksi pemasukan sesuai filter
        $pemasukan = $query->get();
        
        // Hitung total pemasukan
        $totalPemasukan = $pemasukan->sum('jumlah');

        return view('transaksi-pemasukan.laporan.index', compact('pemasukan', 'totalPemasukan', 'filter', 'tanggal'));
    }

    public function laporan_pengeluaran_barang_index(Request $request)
    {
        $filter = $request->input('filter', 'harian'); // Default 'harian' jika tidak ada filter
        $tanggal = $request->input('tanggal'); // tanggal yang dipilih untuk filter
        
        $query = TransaksiPengeluaranBarang::query();
        
        // Filter berdasarkan harian, bulanan, atau tahunan
        if ($filter == 'harian') {
            $query->whereDate('tanggal', Carbon::parse($tanggal)->format('Y-m-d'));
        } elseif ($filter == 'bulanan') {
            $query->whereYear('tanggal', Carbon::parse($tanggal)->format('Y'))
            ->whereMonth('tanggal', Carbon::parse($tanggal)->format('m'));
        } elseif ($filter == 'tahunan') {
            $query->whereYear('tanggal', $tanggal);
        }
        
        // Ambil data transaksi pemasukan sesuai filter
        $pengeluaran = $query->get();
        
        // Hitung total pemasukan
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        return view('transaksi-pengeluaran.laporan.index-barang', compact('pengeluaran', 'totalPengeluaran', 'filter', 'tanggal'));
    }

    public function laporan_pengeluaran_index(Request $request)
{
    $filter = $request->input('filter', 'harian'); // Default 'harian' jika tidak ada filter
    $tanggal = $request->input('tanggal'); // tanggal yang dipilih untuk filter

    $query = TransaksiPengeluaran::query();

    // Filter berdasarkan harian, bulanan, atau tahunan
    if ($filter == 'harian') {
        if ($tanggal) {
            $query->whereDate('tgl_pengeluaran', Carbon::parse($tanggal)->format('Y-m-d'));
        } else {
            $query->whereDate('tgl_pengeluaran', Carbon::today());
        }
    } elseif ($filter == 'bulanan') {
        if ($tanggal) {
            $query->whereYear('tgl_pengeluaran', Carbon::parse($tanggal)->format('Y'))
                  ->whereMonth('tgl_pengeluaran', Carbon::parse($tanggal)->format('m'));
        } else {
            $query->whereMonth('tgl_pengeluaran', Carbon::now()->month)
                  ->whereYear('tgl_pengeluaran', Carbon::now()->year);
        }
    } elseif ($filter == 'tahunan') {
        if ($tanggal) {
            $query->whereYear('tgl_pengeluaran', $tanggal);
        } else {
            $query->whereYear('tgl_pengeluaran', Carbon::now()->year);
        }
    }

    // Ambil data transaksi pengeluaran sesuai filter
    $pengeluarans = $query->get();

    // Menghitung total pengeluaran
    $totalKeseluruhan = $pengeluarans->sum(function ($item) {
        return (float) str_replace('.', '', $item->total); // Menghapus titik dan mengonversi ke float
    });

    return view('transaksi-pengeluaran.laporan.index', [
        'pengeluarans' => $pengeluarans,
        'totalKeseluruhan' => number_format($totalKeseluruhan, 0, ',', '.'),
        'filter' => $filter,
        'tanggal' => $tanggal
    ]);
}


    // public function laporan_pengeluaran_index(Request $request)
    // {

    //     // Menangani filter berdasarkan tanggal
    //     $filter = $request->input('filter', 'harian'); // Default filter 'harian'
    //     $pengeluarans = TransaksiPengeluaran::query();

    //     // Mengambil filter tanggal
    //     if ($filter == 'harian') {
    //         $pengeluarans->whereDate('tgl_pengeluaran', Carbon::today());
    //     } elseif ($filter == 'bulanan') {
    //         $pengeluarans->whereMonth('tgl_pengeluaran', Carbon::now()->month)
    //                       ->whereYear('tgl_pengeluaran', Carbon::now()->year);
    //     } elseif ($filter == 'tahunan') {
    //         $pengeluarans->whereYear('tgl_pengeluaran', Carbon::now()->year);
    //     }

    //     // Ambil data pengeluaran yang difilter
    //     $pengeluarans = $pengeluarans->get();

    //     // Menghitung total keseluruhan
    //     $totalKeseluruhan = $pengeluarans->sum(function ($item) {
    //         return (float) str_replace('.', '', $item->total); // Menghapus titik dan mengonversi ke float
    //     });

    //     // Menyajikan laporan ke view 'laporan.index'
    //     return view('transaksi-pengeluaran.laporan.index', [
    //         'pengeluarans' => $pengeluarans,
    //         'totalKeseluruhan' => number_format($totalKeseluruhan, 0, ',', '.'),
    //         'filter' => $filter
    //     ]);
    // }

    
}
