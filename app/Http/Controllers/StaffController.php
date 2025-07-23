<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\HewanPeliharaan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::paginate(10);
        return view('admin.staff', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:staff',
            'telepon' => 'required',
            'jabatan' => 'required',
        ]);
        $data = $request->only(['nama', 'email', 'telepon', 'jabatan']);
        $data['password'] = bcrypt('password123'); // password default
        Staff::create($data);
        return redirect()->route('admin.staff')->with('success', 'Data staff berhasil ditambahkan');
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('admin.staff_edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:staff,email,' . $id,
            'telepon' => 'required',
            'jabatan' => 'required',
        ]);
        $staff = Staff::findOrFail($id);
        $staff->update($request->all());
        return redirect()->route('admin.staff')->with('success', 'Data staff berhasil diperbarui');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return redirect()->route('admin.staff')->with('success', 'Data staff berhasil dihapus');
    }

    /**
     * Dashboard staff: statistik dan aktivitas
     */
    public function dashboard()
    {
        $statHewan = HewanPeliharaan::count();
        $statCheckin = Transaksi::whereDate('tanggal_masuk', now()->toDateString())->count();
        $statCheckout = Transaksi::whereDate('tanggal_keluar', now()->toDateString())->count();

        // Notifikasi check-out hari ini
        $notifCheckout = Transaksi::whereDate('tanggal_keluar', now()->toDateString())
            ->where('status_layanan', '!=', 'diambil')
            ->count();

        // Notifikasi pembayaran belum lunas (opsional)
        $notifBelumLunas = Transaksi::where('status_pembayaran', '!=', 'lunas')->count();

        return view('staff.dashboard', compact(
            'statHewan', 'statCheckin', 'statCheckout',
            'notifCheckout', 'notifBelumLunas'
        ));
    }

    public function showChangePasswordForm()
    {
        $staff = auth()->guard('staff')->user();
        return view('staff.change_password', compact('staff'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        $staff = auth()->guard('staff')->user();
        if (!$staff) {
            $staff = Staff::find(session('staff_id'));
        }
        $staff->password = Hash::make($request->password);
        $staff->save();
        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    // Transaksi - List
    public function transaksiIndex(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'hewan']);
        if ($request->search) {
            $query->whereHas('pelanggan', function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%');
            })->orWhereHas('hewan', function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->jenis_layanan) {
            $query->where('jenis_layanan', 'like', '%'.$request->jenis_layanan.'%');
        }
        if ($request->status_pembayaran) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }
        $transaksis = $query->orderByDesc('created_at')->get();
        $todayIncome = $transaksis->where('created_at', '>=', now()->startOfDay())->sum('total');
        return view('staff.transaksi', compact('transaksis', 'todayIncome'));
    }

    // Transaksi - Create Form
    public function transaksiCreate()
    {
        $hewans = HewanPeliharaan::all();
        $pelanggans = Pelanggan::all();
        return view('staff.transaksi_create', compact('hewans', 'pelanggans'));
    }

    // Transaksi - Store
    public function transaksiStore(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'hewan_id' => 'required|exists:hewan_peliharaans,id',
            'jenis_layanan' => 'required',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'total_harga' => 'required|numeric',
            'status_pembayaran' => 'required',
        ]);
        $data = $request->all();
        $transaksi = new Transaksi($data);
        $transaksi->save();
        // Integrasi ke jadwal layanan
        $jenisLayanan = $request->jenis_layanan;
        if (!is_array($jenisLayanan)) {
            $jenisLayanan = [$jenisLayanan];
        }
        foreach ($jenisLayanan as $layananNama) {
            $layanan = \App\Models\Layanan::where('nama', $layananNama)->first();
            if ($layanan) {
                \App\Models\JadwalLayanan::create([
                    'hewan_id' => $request->hewan_id,
                    'layanan_id' => $layanan->id,
                    'tanggal' => $request->tanggal_masuk,
                    'jam_mulai' => '09:00',
                    'jam_selesai' => '10:00',
                    'status' => 'menunggu',
                    'keterangan' => 'Otomatis dari transaksi staff',
                ]);
            }
        }
        return redirect()->route('staff.transaksi')->with('success', 'Transaksi & jadwal layanan berhasil ditambahkan.');
    }

    // Transaksi - Show
    public function transaksiShow($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'hewan'])->findOrFail($id);
        return view('staff.transaksi_show', compact('transaksi'));
    }

    // Transaksi - Edit Form
    public function transaksiEdit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $hewans = HewanPeliharaan::all();
        $pelanggans = Pelanggan::all();
        return view('staff.transaksi_edit', compact('transaksi', 'hewans', 'pelanggans'));
    }

    // Transaksi - Update
    public function transaksiUpdate(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'hewan_id' => 'required|exists:hewan_peliharaans,id',
            'jenis_layanan' => 'required',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'total_harga' => 'required|numeric',
            'status_pembayaran' => 'required',
        ]);
        $transaksi = Transaksi::findOrFail($id);
        $data = $request->all();
        if ($request->has('status_layanan_detail')) {
            $data['status_layanan_detail'] = json_encode($request->status_layanan_detail);
        }
        $transaksi->update($data);
        return redirect()->route('staff.transaksi')->with('success', 'Transaksi berhasil diupdate.');
    }

    // Transaksi - Destroy
    public function transaksiDestroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('staff.transaksi')->with('success', 'Transaksi berhasil dihapus.');
    }

    // Transaksi - Cetak Bukti
    public function transaksiCetak($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'hewan'])->findOrFail($id);
        // Bisa diarahkan ke view PDF atau printable
        return view('staff.transaksi_cetak', compact('transaksi'));
    }

    // Transaksi - Riwayat
    public function transaksiHistory(Request $request)
    {
        $query = Transaksi::with(['pelanggan', 'hewan']);
        if ($request->search) {
            $query->whereHas('pelanggan', function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%');
            })->orWhereHas('hewan', function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%');
            });
        }
        $transaksis = $query->orderByDesc('created_at')->get();
        return view('staff.transaksi_history', compact('transaksis'));
    }

    // Hewan - List
    public function hewanIndex(Request $request)
    {
        $query = HewanPeliharaan::with('pelanggan');
        if ($request->search) {
            $query->where('nama', 'like', '%'.$request->search.'%');
        }
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->status_vaksin) {
            $query->where('status_vaksin', $request->status_vaksin);
        }
        $hewans = $query->orderByDesc('created_at')->get();
        return view('staff.hewan', compact('hewans'));
    }

    // Hewan - Create Form
    public function hewanCreate()
    {
        $pelanggans = Pelanggan::all();
        return view('staff.hewan_create', compact('pelanggans'));
    }

    // Hewan - Store
    public function hewanStore(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'ras' => 'nullable',
            'usia' => 'nullable|numeric',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'status_vaksin' => 'required',
        ]);
        HewanPeliharaan::create($request->all());
        return redirect()->route('staff.hewan')->with('success', 'Data hewan berhasil ditambahkan.');
    }

    // Hewan - Edit Form
    public function hewanEdit($id)
    {
        $hewan = HewanPeliharaan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        return view('staff.hewan_edit', compact('hewan', 'pelanggans'));
    }

    // Hewan - Update
    public function hewanUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'ras' => 'nullable',
            'usia' => 'nullable|numeric',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'status_vaksin' => 'required',
        ]);
        $hewan = HewanPeliharaan::findOrFail($id);
        $hewan->update($request->all());
        return redirect()->route('staff.hewan')->with('success', 'Data hewan berhasil diupdate.');
    }

    // Hewan - Destroy
    public function hewanDestroy($id)
    {
        $hewan = HewanPeliharaan::findOrFail($id);
        $hewan->delete();
        return redirect()->route('staff.hewan')->with('success', 'Data hewan berhasil dihapus.');
    }

    // Check-in - List transaksi yang perlu check-in hari ini
    public function checkinIndex(Request $request)
    {
        $transaksis = Transaksi::with(['pelanggan', 'hewan'])
            ->whereDate('tanggal_masuk', now()->toDateString())
            ->where(function($q) {
                $q->where('status_layanan', 'check-in')
                  ->orWhereNull('status_layanan');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('staff.checkin', compact('transaksis'));
    }

    // Check-out - List transaksi yang perlu check-out hari ini
    public function checkoutIndex(Request $request)
    {
        $transaksis = Transaksi::with(['pelanggan', 'hewan'])
            ->whereDate('tanggal_keluar', now()->toDateString())
            ->whereIn('status_layanan', ['sedang dirawat', 'selesai'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('staff.checkout', compact('transaksis'));
    }

    /**
     * Halaman utama penitipan hari ini/aktif untuk staff
     */
    public function penitipanIndex(Request $request)
    {
        $query = Transaksi::with(['hewan', 'pelanggan'])
            ->where(function($q) {
                $q->whereDate('tanggal_masuk', now()->toDateString())
                  ->orWhereNull('status_layanan')
                  ->orWhereIn('status_layanan', ['check-in', 'sedang dirawat', 'selesai']);
            });
        if ($request->filled('search')) {
            $query->whereHas('hewan', function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('status_layanan')) {
            $query->where('status_layanan', $request->status_layanan);
        }
        $transaksis = $query->orderBy('created_at', 'desc')->get();
        return view('staff.penitipan', compact('transaksis'));
    }

    /**
     * Update status layanan transaksi
     */
    public function updateStatusLayanan(Request $request, $id)
    {
        $request->validate([
            'status_layanan' => 'required|in:check-in,sedang dirawat,selesai,diambil',
        ]);
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status_layanan = $request->status_layanan;
        $transaksi->save();
        return back()->with('success', 'Status layanan berhasil diupdate.');
    }
} 