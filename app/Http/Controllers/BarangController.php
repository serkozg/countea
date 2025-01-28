<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        Barang::create($request->all());

        return redirect()->back()->with('success', 'Data Master Barang berhasil ditambah!');
    }

    public function edit_barang(Request $request)
    {
        $id = $request->id;
        $data = Barang::find($id);
        return response()->json(['data' => $data]);
    }

    public function update_barang(Request $request)
    {
        $id = $request->id;
        $get_data = [
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok,
            'type' => $request->type,
        ];

        $data_save = Barang::find($id);
        $save = $data_save->update($get_data);

        if ($save) {
            return response()->json(['message' => 'Data berhasil di perbaharui'], 200);
        } else {
            return response()->json(['message' => 'Data gagal di perbaharui']);
        }
    }

    public function destroy($id)
    {
        $data = Barang::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data Berhasil di Hapus');
    }

}
