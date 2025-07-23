<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Staff;
use App\Models\HewanPeliharaan;
use App\Models\Transaksi;
use App\Models\Layanan;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();
        $statPelanggan = Pelanggan::count();
        $statHewan = HewanPeliharaan::count();
        $statTransaksi = Transaksi::count();
        $statStaff = Staff::count();

        $pelangganBaru = Pelanggan::whereDate('created_at', $today)->count();
        $hewanBaru = HewanPeliharaan::whereDate('created_at', $today)->count();
        $transaksiBaru = Transaksi::whereDate('created_at', $today)->count();
        $staffBaru = Staff::whereDate('created_at', $today)->count();

        return view('admin.dashboard', compact('statPelanggan', 'statHewan', 'statTransaksi', 'statStaff', 'pelangganBaru', 'hewanBaru', 'transaksiBaru', 'staffBaru'));
    }

    public function index(Request $request)
    {
        // Jika route admin/hewan, tampilkan data hewan (anjing & kucing saja)
        if (request()->is('admin/hewan*')) {
            $keyword = $request->input('search');
            $jenis = $request->input('jenis');
            $statusVaksin = $request->input('status_vaksin');
            $hewans = HewanPeliharaan::with('pelanggan')
                ->whereIn('jenis', ['anjing', 'kucing'])
                ->when($jenis, function($query, $jenis) {
                    $query->where('jenis', $jenis);
                })
                ->when($statusVaksin, function($query, $statusVaksin) {
                    $query->where('status_vaksin', $statusVaksin);
                })
                ->when($keyword, function($query, $keyword) {
                    $query->where(function($q) use ($keyword) {
                        $q->where('nama', 'like', "%$keyword%")
                          ->orWhere('ras', 'like', "%$keyword%")
                          ->orWhere('jenis', 'like', "%$keyword%")
                        ;
                    });
                })
                ->get();
            return view('admin.hewan', compact('hewans', 'keyword', 'jenis', 'statusVaksin'));
        }
        // Jika route admin/transaksi, tampilkan data transaksi
        elseif (request()->is('admin/transaksi*')) {
            $keyword = $request->input('search');
            $statusPembayaran = $request->input('status_pembayaran');
            $jenisLayanan = $request->input('jenis_layanan');
            $transaksis = Transaksi::with(['pelanggan', 'hewan'])
                ->when($statusPembayaran, function($query, $statusPembayaran) {
                    $query->where('status_pembayaran', $statusPembayaran);
                })
                ->when($jenisLayanan, function($query, $jenisLayanan) {
                    $query->where('jenis_layanan', 'like', '%' . $jenisLayanan . '%');
                })
                ->when($keyword, function($query, $keyword) {
                    $query->where(function($q) use ($keyword) {
                        $q->whereHas('pelanggan', function($subQ) use ($keyword) {
                            $subQ->where('nama', 'like', "%$keyword%");
                        })
                        ->orWhereHas('hewan', function($subQ) use ($keyword) {
                            $subQ->where('nama', 'like', "%$keyword%");
                        })
                        ->orWhere('jenis_layanan', 'like', "%$keyword%");
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Calculate statistics
            $todayIncome = Transaksi::whereDate('created_at', today())->sum('total_harga');
            
            return view('admin.transaksi', compact('transaksis', 'keyword', 'statusPembayaran', 'jenisLayanan', 'todayIncome'));
        }
        // Default: admin/pelanggan
        $keyword = $request->input('search');
        $pelanggans = Pelanggan::with('hewans')
            ->when($keyword, function($query, $keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('nama', 'like', "%$keyword%")
                      ->orWhere('email', 'like', "%$keyword%")
                      ->orWhere('telepon', 'like', "%$keyword%")
                    ;
                });
            })
            ->paginate(10);
        $totalPelanggan = Pelanggan::count();
        $pelangganBaru = Pelanggan::where('created_at', '>=', now()->subDays(30))->count();
        $totalHewan = HewanPeliharaan::count();
        return view('admin.pelanggan', compact('pelanggans', 'totalHewan', 'keyword', 'totalPelanggan', 'pelangganBaru'));
    }

    public function staff()
    {
        $staffs = Staff::all();
        return view('admin.staff', compact('staffs'));
    }

    public function create()
    {
        // Tambah pelanggan
        if (request()->is('admin/pelanggan*')) {
            return view('admin.pelanggan_create');
        }
        // Tambah hewan
        if (request()->is('admin/hewan*')) {
            $pelanggans = Pelanggan::all();
            return view('admin.hewan_create', compact('pelanggans'));
        }
        // Tambah transaksi
        if (request()->is('admin/transaksi*')) {
            $pelanggans = Pelanggan::with('hewans')->get();
            $hewans = HewanPeliharaan::with('pelanggan')->get();
            $layanans = \App\Models\Layanan::all();
            return view('admin.transaksi_create', compact('pelanggans', 'hewans', 'layanans'));
        }
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        // Tambah pelanggan
        if (request()->is('admin/pelanggan*')) {
            $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|unique:pelanggans,email',
                'telepon' => 'required|string|max:20',
            ]);
            $data = $request->only(['nama', 'email', 'telepon']);
            $data['password'] = bcrypt('password123'); // password default
            Pelanggan::create($data);
            return redirect()->route('admin.pelanggan')->with('success', 'Data pelanggan berhasil ditambahkan');
        }
        // Tambah hewan
        if (request()->is('admin/hewan*')) {
            return $this->hewanStore($request);
        } elseif (request()->is('admin/transaksi*')) {
            return $this->transaksiStore($request);
        }
        return redirect()->route('admin.dashboard');
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with('hewans')->findOrFail($id);
        return view('admin.pelanggan_show', compact('pelanggan'));
    }

    public function edit($id)
    {
        // Jika route admin/hewan, tampilkan form edit hewan
        if (request()->is('admin/hewan*')) {
            $hewan = HewanPeliharaan::findOrFail($id);
            $pelanggans = Pelanggan::all();
            return view('admin.hewan_edit', compact('hewan', 'pelanggans'));
        }
        // Jika route admin/transaksi, tampilkan form edit transaksi
        if (request()->is('admin/transaksi*')) {
            return $this->transaksiEdit($id);
        }
        // Default: admin/pelanggan
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan_edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        // Check if this is for hewan or transaksi based on the route
        if (request()->is('admin/hewan*')) {
            return $this->hewanUpdate($request, $id);
        } elseif (request()->is('admin/transaksi*')) {
            return $this->transaksiUpdate($request, $id);
        }
        
        return redirect()->route('admin.dashboard');
    }

    public function destroy($id)
    {
        // Check if this is for hewan or transaksi based on the route
        if (request()->is('admin/hewan*')) {
            return $this->hewanDestroy($id);
        } elseif (request()->is('admin/transaksi*')) {
            return $this->transaksiDestroy($id);
        }
        
        return redirect()->route('admin.dashboard');
    }

    public function laporan(Request $request)
    {
        // Get filter parameters
        $periode = $request->input('periode', 'month');
        $jenisLayanan = $request->input('jenis_layanan');
        $statusPembayaran = $request->input('status_pembayaran');
        
        // Base query for transactions
        $transaksiQuery = Transaksi::query();
        
        // Apply period filter
        switch ($periode) {
            case 'today':
                $transaksiQuery->whereDate('created_at', today());
                break;
            case 'week':
                $transaksiQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $transaksiQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                break;
            case 'quarter':
                $transaksiQuery->whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()]);
                break;
            case 'year':
                $transaksiQuery->whereYear('created_at', now()->year);
                break;
        }
        
        // Apply service filter
        if ($jenisLayanan) {
            $transaksiQuery->where('jenis_layanan', 'like', '%' . $jenisLayanan . '%');
        }
        
        // Apply payment status filter
        if ($statusPembayaran) {
            $transaksiQuery->where('status_pembayaran', $statusPembayaran);
        }
        
        $filteredTransactions = $transaksiQuery->get();
        
        $totalIncome = $filteredTransactions->sum('total_harga');
        $monthlyTransactions = $filteredTransactions->count();
        $totalHewan = HewanPeliharaan::whereIn('jenis', ['anjing', 'kucing'])->count();
        $totalPelanggan = Pelanggan::count();
        
        $layananHarga = Layanan::pluck('harga', 'nama')->mapWithKeys(function($v, $k) {
            return [strtolower($k) => $v];
        })->toArray();
        $serviceIncome = [
            'penitipan' => 0,
            'grooming' => 0,
            'vaksinasi' => 0,
            'checkup' => 0,
        ];
        $serviceCount = [
            'penitipan' => 0,
            'grooming' => 0,
            'vaksinasi' => 0,
            'checkup' => 0,
        ];
        foreach ($filteredTransactions as $transaksi) {
            $layanans = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
            if (is_array($layanans) && count($layanans) > 0) {
                foreach ($layanans as $layanan) {
                    $layanan = strtolower($layanan);
                    if (isset($serviceIncome[$layanan]) && isset($layananHarga[$layanan])) {
                        $serviceIncome[$layanan] += $layananHarga[$layanan];
                        $serviceCount[$layanan]++;
                    }
                }
            }
        }
        
        // Monthly income for chart (last 6 months)
        $monthlyIncome = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthQuery = Transaksi::query();
            
            // Apply same filters to monthly data
            if ($jenisLayanan) {
                $monthQuery->where('jenis_layanan', 'like', '%' . $jenisLayanan . '%');
            }
            if ($statusPembayaran) {
                $monthQuery->where('status_pembayaran', $statusPembayaran);
            }
            
            $income = $monthQuery->whereYear('created_at', $month->year)
                              ->whereMonth('created_at', $month->month)
                              ->sum('total_harga');
            $monthlyIncome[] = $income;
        }
        
        // Service distribution for chart (using filtered data)
        $serviceDistribution = [
            'penitipan' => $filteredTransactions->filter(function($transaksi) {
                $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                return is_array($layanan) && in_array('penitipan', $layanan);
            })->count(),
            'grooming' => $filteredTransactions->filter(function($transaksi) {
                $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                return is_array($layanan) && in_array('grooming', $layanan);
            })->count(),
            'vaksinasi' => $filteredTransactions->filter(function($transaksi) {
                $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                return is_array($layanan) && in_array('vaksinasi', $layanan);
            })->count(),
            'checkup' => $filteredTransactions->filter(function($transaksi) {
                $layanan = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                return is_array($layanan) && in_array('checkup', $layanan);
            })->count(),
        ];
        
        return view('admin.laporan', compact(
            'totalIncome', 
            'monthlyTransactions', 
            'totalHewan',
            'totalPelanggan',
            'serviceIncome',
            'serviceCount',
            'monthlyIncome',
            'serviceDistribution',
            'periode',
            'jenisLayanan',
            'statusPembayaran'
        ));
    }

    public function showChangePasswordForm()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.change_password', compact('admin'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        $admin = \App\Models\Admin::find(session('admin_id'));
        $admin->password = Hash::make($request->password);
        $admin->save();
        return redirect()->back()->with('success', 'Password berhasil diubah.');
    }

    // Hewan CRUD Methods
    public function hewanCreate()
    {
        $pelanggans = Pelanggan::all();
        return view('admin.hewan_create', compact('pelanggans'));
    }

    public function hewanStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'ras' => 'nullable|string|max:255',
            'usia' => 'nullable|integer|min:0',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            // status_vaksin tidak wajib untuk admin
        ]);

        $hewan = HewanPeliharaan::create($request->all());
        return redirect()->route('admin.pelanggan.show', $hewan->pelanggan_id)->with('success', 'Hewan berhasil ditambahkan');
    }

    public function hewanEdit($id)
    {
        $hewan = HewanPeliharaan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        return view('admin.hewan_edit', compact('hewan', 'pelanggans'));
    }

    public function hewanUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'ras' => 'nullable|string|max:255',
            'usia' => 'nullable|integer|min:0',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'status_vaksin' => 'required|in:vaccinated,not_vaccinated,partial',
        ]);

        $hewan = HewanPeliharaan::findOrFail($id);
        $hewan->update($request->all());
        return redirect()->route('admin.pelanggan.show', $hewan->pelanggan_id)->with('success', 'Data hewan berhasil diperbarui');
    }

    public function hewanDestroy($id)
    {
        $hewan = HewanPeliharaan::findOrFail($id);
        $hewan->delete();
        return redirect()->route('admin.hewan')->with('success', 'Hewan berhasil dihapus');
    }

    // Transaksi CRUD Methods
    public function transaksiStore(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'hewan_id' => 'required|exists:hewan_peliharaans,id',
            'jenis_layanan' => 'required|array|min:1',
            'jenis_layanan.*' => 'in:penitipan,grooming,vaksinasi,checkup',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'total_harga' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer,qris,dana,ovo,gopay',
            'status_pembayaran' => 'required|in:belum_lunas,dp,lunas',
            'jumlah_dibayar' => 'nullable|numeric|min:0|lte:total_harga',
        ]);

        $data = $request->all();
        $data['jenis_layanan'] = json_encode($request->jenis_layanan);
        $jenisLayanan = $request->jenis_layanan;
        if (!in_array('penitipan', $jenisLayanan)) {
            $data['tanggal_keluar'] = $request->tanggal_masuk;
        } elseif (empty($request->tanggal_keluar)) {
            $data['tanggal_keluar'] = $request->tanggal_masuk;
        }
        if ($request->status_pembayaran === 'lunas') {
            $data['jumlah_dibayar'] = $request->total_harga;
        } elseif ($request->status_pembayaran === 'belum_lunas') {
            $data['jumlah_dibayar'] = 0;
        }
        $transaksi = Transaksi::create($data);
        
        foreach ($jenisLayanan as $layananNama) {
            $layanan = Layanan::where('nama', $layananNama)->first();
            if ($layanan) {
                \App\Models\JadwalLayanan::create([
                    'hewan_id' => $request->hewan_id,
                    'layanan_id' => $layanan->id,
                    'tanggal' => $request->tanggal_masuk,
                    'jam_mulai' => '09:00',
                    'jam_selesai' => '10:00',
                    'status' => 'menunggu',
                    'keterangan' => 'Otomatis dari booking/transaksi',
                ]);
            }
        }
        return redirect()->route('admin.transaksi')->with('success', 'Transaksi & jadwal layanan berhasil ditambahkan');
    }

    public function transaksiEdit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pelanggans = Pelanggan::with('hewans')->get();
        $hewans = HewanPeliharaan::with('pelanggan')->get();
        $layanans = Layanan::all();
        return view('admin.transaksi_edit', compact('transaksi', 'pelanggans', 'hewans', 'layanans'));
    }

    public function transaksiUpdate(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'hewan_id' => 'required|exists:hewan_peliharaans,id',
            'jenis_layanan' => 'required|array|min:1',
            'jenis_layanan.*' => 'in:penitipan,grooming,vaksinasi,checkup',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
            'total_harga' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer,qris,dana,ovo,gopay',
            'status_pembayaran' => 'required|in:belum_lunas,dp,lunas',
            'jumlah_dibayar' => 'nullable|numeric|min:0|lte:total_harga',
        ]);

        $data = $request->all();
        $data['jenis_layanan'] = json_encode($request->jenis_layanan);
        
        // Jika tidak ada penitipan, set tanggal keluar sama dengan tanggal masuk
        $jenisLayanan = $request->jenis_layanan;
        if (!in_array('penitipan', $jenisLayanan)) {
            $data['tanggal_keluar'] = $request->tanggal_masuk;
        } elseif (empty($request->tanggal_keluar)) {
            // Jika ada penitipan tapi tanggal keluar kosong, set sama dengan tanggal masuk (1 hari)
            $data['tanggal_keluar'] = $request->tanggal_masuk;
        }

        // Set jumlah dibayar berdasarkan status pembayaran
        if ($request->status_pembayaran === 'lunas') {
            $data['jumlah_dibayar'] = $request->total_harga;
        } elseif ($request->status_pembayaran === 'belum_lunas') {
            $data['jumlah_dibayar'] = 0;
        }

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($data);
        return redirect()->route('admin.transaksi')->with('success', 'Transaksi berhasil diperbarui');
    }

    public function transaksiDestroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return redirect()->route('admin.transaksi')->with('success', 'Transaksi berhasil dihapus');
    }

    // Tambahan: Update status jadwal layanan
    public function updateJadwalStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,dibatalkan'
        ]);
        $jadwal = \App\Models\JadwalLayanan::findOrFail($id);
        $jadwal->status = $request->status;
        $jadwal->save();
        return redirect()->back()->with('success', 'Status layanan berhasil diperbarui');
    }
} 