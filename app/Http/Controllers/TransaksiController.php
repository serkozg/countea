<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\MasterTransaksi;
use App\Models\Transaksi;
use App\Models\TransaksiPemasukan;
use App\Models\TransaksiPengeluaran;
use App\Models\TransaksiPengeluaranBarang;

class TransaksiController extends Controller
{
    //menu data master
    public function master_index()
    {
        $master_transaksi = MasterTransaksi::all();
        return view('transaksi-pengeluaran.master-transaksi.index', compact('master_transaksi'));
    }

    public function master_index_store(Request $request)
    {
        $data                 = new MasterTransaksi();
        $data->nama_transaksi = $request->nama_transaksi;
        $data->type           = $request->type;
        $data->keterangan     = $request->keterangan;
        $data->save();

        return redirect()->back()->with('success', 'Data Master berhasil ditambah');
    }

    public function master_index_edit(Request $request)
    {
        $id   = $request->id;
        $data = MasterTransaksi::find($id);
        return response()->json(['data' => $data]);
    }

    public function master_index_update(Request $request)
    {
        $id = $request->id;
        $get_data = [
            'nama_transaksi' => $request->nama_transaksi,
            'type'           => $request->type,
            'keterangan'     => $request->keterangan,
        ];

        $data_save = MasterTransaksi::find($id);
        $save = $data_save->update($get_data);

        if ($save) {
            return response()->json(['message' => 'Data berhasil di perbaharui'], 200);
        } else {
            return response()->json(['message' => 'Data gagal di perbaharui']);
        }
    }

    public function master_index_delete($id)
    {
        $data = MasterTransaksi::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }

    //menu transaksi pemasukan
    public function transaksi_pemasukan_index()
    {  
        return view('transaksi-pemasukan.index');
    }

    public function pemasukan_index()
    {  
        $transaksi_pemasukan = TransaksiPemasukan::all();
        $data_barang         = Barang::all();
        return view('transaksi-pemasukan.transaksi.index', compact('transaksi_pemasukan','data_barang'));
    }

    public function pemasukan_store(Request $request)
    {
        $pemasukan = TransaksiPemasukan::create($request->all());

        if($request->hasFile('image')) {
            $request->file('image')->move('images/pemasukan/',$request->file('image')->getClientOriginalName());
            $pemasukan->image = $request->file('image')->getClientOriginalName();
            $pemasukan->save();
        }

        $barang = Barang::where('id', $request->barang_id)->first();

        if ($barang) {
            $barang->stok += $request->jumlah;
            $barang->save();
        }

        return redirect()->back()->with('success', 'Data Pemasukan berhasil ditambah');
    }

    public function pemasukan_delete($id)
    {
        $transaksi = TransaksiPemasukan::find($id);
        $transaksi->delete();
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }

    //menu transaksi pengeluaran
    public function transaksi_pengeluaran_index()
    {
        return view('transaksi-pengeluaran.index');
    }

    public function pengeluaran_index()
    {
        $transaksi_pengeluaran = TransaksiPengeluaran::all();
        $master_transaksi      = MasterTransaksi::all();
        return view('transaksi-pengeluaran.transaksi.index', compact('transaksi_pengeluaran','master_transaksi'));
    }

    public function pengeluaran_store(Request $request)
    {
        $pengeluaran = TransaksiPengeluaran::create($request->all());

        if($request->hasFile('image')) {
            $request->file('image')->move('images/pengeluaran/',$request->file('image')->getClientOriginalName());
            $pengeluaran->image = $request->file('image')->getClientOriginalName();
            $pengeluaran->save();
        }

        return redirect()->back()->with('success', 'Data Pengeluaran berhasil ditambah');
    }

    public function pengeluaran_delete($id)
    {
        $transaksi = TransaksiPengeluaran::find($id);
        $transaksi->delete();
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }

    //menu pengeluaran barang
    public function pengeluaran_barang_index()
    {
        $transaksi_pengeluaran_barang = TransaksiPengeluaranBarang::all();
        $data_barang                  = Barang::all();
        return view('transaksi-pengeluaran.transaksi.index-barang', compact('transaksi_pengeluaran_barang','data_barang'));
    }

    public function pengeluaran_barang_store(Request $request)
    {
        $pemasukan = TransaksiPengeluaranBarang::create($request->all());

        if($request->hasFile('image')) {
            $request->file('image')->move('images/pengeluaran/',$request->file('image')->getClientOriginalName());
            $pemasukan->image = $request->file('image')->getClientOriginalName();
            $pemasukan->save();
        }

        $barang = Barang::where('id', $request->barang_id)->first();

        if ($barang) {
            $barang->stok -= $request->jumlah;
            $barang->save();
        }

        return redirect()->back()->with('success', 'Data Pengeluaran Barang berhasil ditambah!');
    }

    public function pengeluaran_barang_delete($id)
    {
        $transaksi = TransaksiPengeluaranBarang::find($id);
        $transaksi->delete();
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }


}
