<?php

namespace App\Http\Controllers;

use App\Models\HewanPeliharaan;
use Illuminate\Http\Request;

class HewanPeliharaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil hewan milik pelanggan yang sedang login
        $hewan = HewanPeliharaan::where('pelanggan_id', session('pelanggan_id'))->get();
        return view('pelanggan.hewan', compact('hewan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggan.hewan_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!session('pelanggan_id')) {
            return redirect()->route('login')->with('error', 'Silakan login sebagai pelanggan!');
        }
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'ras' => 'nullable',
            'usia' => 'nullable|integer|min:0',
        ]);
        $data = $request->all();
        $data['pelanggan_id'] = session('pelanggan_id');
        HewanPeliharaan::create($data);
        return redirect()->route('pelanggan.hewan')->with('success', 'Hewan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(HewanPeliharaan $hewanPeliharaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hewan = HewanPeliharaan::where('id', $id)
            ->where('pelanggan_id', session('pelanggan_id'))
            ->firstOrFail();
        return view('pelanggan.hewan_edit', compact('hewan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $hewan)
    {
        $hewan = HewanPeliharaan::where('id', $hewan)
            ->where('pelanggan_id', session('pelanggan_id'))
            ->firstOrFail();
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'ras' => 'nullable',
            'usia' => 'nullable|integer|min:0',
        ]);
        $hewan->update($request->all());
        return redirect()->route('pelanggan.hewan')->with('success', 'Hewan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hewan = HewanPeliharaan::where('id', $id)->where('pelanggan_id', auth()->id())->firstOrFail();
        $hewan->delete();
        return redirect()->route('pelanggan.hewan')->with('success', 'Hewan berhasil dihapus');
    }
}
