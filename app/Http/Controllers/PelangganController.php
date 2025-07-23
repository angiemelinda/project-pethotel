<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\HewanPeliharaan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\JadwalLayanan;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        // Check if this is an admin route
        if (request()->is('admin/pelanggan*')) {
            $pelanggans = Pelanggan::with('hewans')->get();
            $totalHewan = HewanPeliharaan::count();
            return view('admin.pelanggan', compact('pelanggans', 'totalHewan'));
        }

        // Regular pelanggan route
        $keyword = $request->input('search');

        $pelanggans = Pelanggan::when($keyword, function ($query, $keyword) {
            return $query->where('nama', 'like', "%$keyword%")
                        ->orWhere('email', 'like', "%$keyword%")
                        ->orWhere('telepon', 'like', "%$keyword%");
        })->paginate(10);

        return view('pelanggan.index', compact('pelanggans', 'keyword'));
    }

    public function create()
    {
        // Check if this is an admin route
        if (request()->is('admin/pelanggan*')) {
            return view('admin.pelanggan_create');
        }

        return view('pelanggan.pelanggan_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'telepon' => 'required|string|max:20',
        ]);

        $data = $request->only(['nama', 'email', 'telepon']);
        $data['password'] = bcrypt('password123'); // password default

        Pelanggan::create($data);
        
        // Check if this is an admin route
        if (request()->is('admin/pelanggan*')) {
            return redirect()->route('admin.pelanggan')->with('success', 'Data pelanggan berhasil ditambahkan');
        }

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function edit(Pelanggan $pelanggan)
    {
        // Check if this is an admin route
        if (request()->is('admin/pelanggan*')) {
            return view('admin.pelanggan_edit', compact('pelanggan'));
        }

        return view('pelanggan.pelanggan_edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email,' . $pelanggan->id,
            'telepon' => 'required|string|max:20',
        ]);

        $pelanggan->update($request->all());
        
        // Check if this is an admin route
        if (request()->is('admin/pelanggan*')) {
            return redirect()->route('admin.pelanggan')->with('success', 'Data pelanggan berhasil diperbarui');
        }

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        
        // Check if this is an admin route
        if (request()->is('admin/pelanggan*')) {
            return redirect()->route('admin.pelanggan')->with('success', 'Data pelanggan berhasil dihapus');
        }

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus');
    }

    public function dashboard()
    {
        try {
            $pelangganId = session('pelanggan_id');
            $totalHewan = HewanPeliharaan::where('pelanggan_id', $pelangganId)->count();
            $totalBookingAktif = Transaksi::where('pelanggan_id', $pelangganId)
                ->where('status_layanan', '!=', 'diambil')
                ->count();
            $totalTransaksi = Transaksi::where('pelanggan_id', $pelangganId)->count();

            return view('pelanggan.dashboard', compact('totalHewan', 'totalBookingAktif', 'totalTransaksi'));
        } catch (\Exception $e) {
            return view('pelanggan.dashboard', [
                'totalHewan' => 0,
                'totalBookingAktif' => 0,
                'totalTransaksi' => 0
            ]);
        }
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with(['hewans' => function($q) {
            $q->whereIn('jenis', ['anjing', 'kucing']);
        }, 'transaksis'])->findOrFail($id);
        return view('admin.pelanggan_show', compact('pelanggan'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email',
            'telepon' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Pelanggan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function booking()
    {
        $pelangganId = session('pelanggan_id');
        $hewan = HewanPeliharaan::where('pelanggan_id', $pelangganId)->get();
        $layanans = \App\Models\Layanan::all();
        return view('pelanggan.booking', compact('hewan', 'layanans'));
    }

    public function bookingCreate()
    {
        $pelangganId = session('pelanggan_id');
        $hewans = HewanPeliharaan::where('pelanggan_id', $pelangganId)->get();
        return view('pelanggan.booking_create', compact('hewans'));
    }

    public function bookingStore(Request $request)
    {
        $request->validate([
            'hewan_id' => 'required|exists:hewan_peliharaans,id',
            'jenis_layanan' => 'required|array|min:1',
            'jenis_layanan.*' => 'in:penitipan,grooming,vaksinasi,checkup',
            'tanggal_masuk' => 'required|date',
        ]);
        $data = $request->only(['hewan_id', 'tanggal_masuk']);
        $data['pelanggan_id'] = session('pelanggan_id');
        $data['status_layanan'] = 'check-in';
        $data['tanggal_keluar'] = $request->tanggal_masuk; // default 1 hari
        // Ambil harga semua layanan yang dipilih
        $totalHarga = 0;
        foreach ($request->jenis_layanan as $layanan) {
            $layananModel = \App\Models\Layanan::where('nama', $layanan)->first();
            $totalHarga += $layananModel ? $layananModel->harga : 0;
        }
        $data['jenis_layanan'] = json_encode($request->jenis_layanan);
        $data['total_harga'] = $totalHarga;
        Transaksi::create($data);
        // Integrasi ke jadwal layanan
        foreach ($request->jenis_layanan as $layananNama) {
            $layanan = \App\Models\Layanan::where('nama', $layananNama)->first();
            if ($layanan) {
                JadwalLayanan::create([
                    'hewan_id' => $request->hewan_id,
                    'layanan_id' => $layanan->id,
                    'tanggal' => $request->tanggal_masuk,
                    'jam_mulai' => '09:00',
                    'jam_selesai' => '10:00',
                    'status' => 'menunggu',
                    'keterangan' => 'Otomatis dari booking pelanggan',
                ]);
            }
        }
        return redirect()->route('pelanggan.transaksi')->with('success', 'Booking & jadwal layanan berhasil ditambahkan! Silakan cek status di halaman transaksi.');
    }

    public function profile()
    {
        $pelanggan = Pelanggan::find(session('pelanggan_id'));
        return view('pelanggan.profile', compact('pelanggan'));
    }

    public function profileUpdate(Request $request)
    {
        $pelanggan = Pelanggan::find(session('pelanggan_id'));
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email,' . $pelanggan->id,
            'password' => 'nullable|string|min:6',
        ]);
        $pelanggan->nama = $request->nama;
        $pelanggan->email = $request->email;
        if ($request->filled('password')) {
            $pelanggan->password = bcrypt($request->password);
        }
        $pelanggan->save();
        return redirect()->route('pelanggan.profile')->with('success', 'Profile berhasil diperbarui!');
    }

    public function transaksi()
    {
        $pelangganId = session('pelanggan_id');
        $transaksis = Transaksi::where('pelanggan_id', $pelangganId)->get();
        return view('pelanggan.transaksi', compact('transaksis'));
    }
}