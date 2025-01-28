<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangan = Keuangan::all();
        return view('keuangan.index', compact('keuangan'));
    }

    public function keuangan_store(Request $request)
    {
        $keuangan = Keuangan::create($request->all());

        if($request->hasFile('image')) {
            $request->file('image')->move('images/keuangan/',$request->file('image')->getClientOriginalName());
            $keuangan->image = $request->file('image')->getClientOriginalName();
            $keuangan->save();
        }

        return redirect()->back()->with('success', 'Data Keuangan berhasil ditambah!');
    }

    public function edit_keuangan(Request $request)
    {
        $id = $request->id;
        $data = Keuangan::find($id);
        return response()->json(['data' => $data]);
    }

    public function update_keuangan(Request $request)
    {
        $id = $request->id;
        $get_data = [
            'tgl_pelunasan' => $request->tgl_pelunasan,
            'status'        => '2',
        ];

        $data_save = Keuangan::find($id);
        $save = $data_save->update($get_data);

        if ($save) {
            return response()->json(['message' => 'Data berhasil di perbaharui'], 200);
        } else {
            return response()->json(['message' => 'Data gagal di perbaharui']);
        }
    }

    public function update_keuangan_image(Request $request)
    {
        $data_save = Keuangan::find($request->id);
        if($request->hasFile('image')) {
            $request->file('image')->move('images/keuangan/',$request->file('image')->getClientOriginalName());
            $data_save->image = $request->file('image')->getClientOriginalName();
            $data_save->save();
        }

        if ($data_save) {
            return response()->json(['message' => 'Data berhasil di perbaharui'], 200);
        } else {
            return response()->json(['message' => 'Data gagal di perbaharui']);
        }
    }
}
