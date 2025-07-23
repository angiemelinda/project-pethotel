<?php

namespace App\Http\Controllers;

use App\Models\JadwalLayanan;
use App\Models\HewanPeliharaan;
use App\Models\Layanan;
use Illuminate\Http\Request;

class JadwalLayananController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalLayanan::with(['hewan', 'layanan'])
            ->where('tanggal', now()->toDateString());
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $jadwals = $query->orderBy('jam_mulai')->get();
        return view('jadwal_layanan.index', compact('jadwals'));
    }

    public function create()
    {
        $hewans = HewanPeliharaan::orderBy('nama')->get();
        $layanans = Layanan::orderBy('nama')->get();
        return view('jadwal_layanan.create', compact('hewans', 'layanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hewan_id' => 'required|exists:hewan_peliharaans,id',
            'layanan_id' => 'required|exists:layanans,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|in:menunggu,proses,selesai',
            'keterangan' => 'nullable|string',
        ]);
        JadwalLayanan::create($request->all());
        return redirect()->route('jadwal-layanan.index')->with('success', 'Jadwal layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalLayanan::findOrFail($id);
        $hewans = HewanPeliharaan::orderBy('nama')->get();
        $layanans = Layanan::orderBy('nama')->get();
        return view('jadwal_layanan.edit', compact('jadwal', 'hewans', 'layanans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hewan_id' => 'required|exists:hewan_peliharaans,id',
            'layanan_id' => 'required|exists:layanans,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|in:menunggu,proses,selesai',
            'keterangan' => 'nullable|string',
        ]);
        $jadwal = JadwalLayanan::findOrFail($id);
        $jadwal->update($request->all());
        return redirect()->route('jadwal-layanan.index')->with('success', 'Jadwal layanan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalLayanan::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal-layanan.index')->with('success', 'Jadwal layanan berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai',
        ]);
        $jadwal = JadwalLayanan::findOrFail($id);
        $jadwal->status = $request->status;
        $jadwal->save();
        return back()->with('success', 'Status layanan berhasil diupdate.');
    }
} 