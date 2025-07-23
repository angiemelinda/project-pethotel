<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi (Admin) - Pet Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-indigo-700 flex items-center gap-2"><span>Edit Transaksi</span> <span>💰</span></h1>
        <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold mb-1">Pelanggan</label>
                <select name="pelanggan_id" id="pelanggan_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required onchange="updateHewanOptions()">
                    <option value="">Pilih Pelanggan</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}" 
                                data-hewans='@json($pelanggan->hewans)'
                                {{ $transaksi->pelanggan_id == $pelanggan->id ? 'selected' : '' }}>
                            {{ $pelanggan->nama }} ({{ $pelanggan->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Hewan</label>
                <select name="hewan_id" id="hewan_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required>
                    <option value="">Pilih Hewan</option>
                    @foreach($hewans as $hewan)
                        <option value="{{ $hewan->id }}" 
                                data-pelanggan-id="{{ $hewan->pelanggan_id }}"
                                {{ $transaksi->hewan_id == $hewan->id ? 'selected' : '' }}>
                            {{ $hewan->nama }} ({{ $hewan->jenis }}) - {{ $hewan->pelanggan->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Jenis Layanan</label>
                <div class="space-y-2">
                    @php
                        $layananArray = is_string($transaksi->jenis_layanan) ? json_decode($transaksi->jenis_layanan, true) : $transaksi->jenis_layanan;
                        $layananArray = is_array($layananArray) ? $layananArray : [$transaksi->jenis_layanan];
                    @endphp
                    @foreach($layanans as $layanan)
                        <label class="flex items-center">
                            <input type="checkbox" name="jenis_layanan[]" value="{{ strtolower($layanan->nama) }}" data-harga="{{ $layanan->harga }}" class="mr-2" onchange="handleLayananChange()" {{ in_array(strtolower($layanan->nama), $layananArray) ? 'checked' : '' }}>
                            <span>{{ $layanan->nama }} (Rp {{ number_format($layanan->harga, 0, ',', '.') }})</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" value="{{ $transaksi->tanggal_masuk }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required onchange="handleTanggalChange()">
            </div>
            <div id="tanggal_keluar_container">
                <label class="block text-sm font-semibold mb-1">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" id="tanggal_keluar" value="{{ $transaksi->tanggal_keluar }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" onchange="handleTanggalChange()">
                <p class="text-xs text-gray-500 mt-1">*Kosongkan jika hewan tidak menginap</p>
            </div>
            <div id="durasi_container">
                <label class="block text-sm font-semibold mb-1">Durasi (hari)</label>
                <input type="number" id="durasi" min="0" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" readonly>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Total Harga</label>
                <input type="number" name="total_harga" id="total_harga" min="0" step="0.01" value="{{ $transaksi->total_harga }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required readonly>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required>
                    <option value="">Pilih Metode</option>
                    <option value="cash" {{ $transaksi->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ $transaksi->metode_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="qris" {{ $transaksi->metode_pembayaran == 'qris' ? 'selected' : '' }}>QRIS</option>
                    <option value="dana" {{ $transaksi->metode_pembayaran == 'dana' ? 'selected' : '' }}>DANA</option>
                    <option value="ovo" {{ $transaksi->metode_pembayaran == 'ovo' ? 'selected' : '' }}>OVO</option>
                    <option value="gopay" {{ $transaksi->metode_pembayaran == 'gopay' ? 'selected' : '' }}>GoPay</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Status Pembayaran</label>
                <select name="status_pembayaran" id="status_pembayaran" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" required onchange="handleStatusPembayaranChange()">
                    <option value="">Pilih Status</option>
                    <option value="belum_lunas" {{ $transaksi->status_pembayaran == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="dp" {{ $transaksi->status_pembayaran == 'dp' ? 'selected' : '' }}>DP (Down Payment)</option>
                    <option value="lunas" {{ $transaksi->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            <div id="jumlah_dibayar_container">
                <label class="block text-sm font-semibold mb-1">Jumlah Dibayar</label>
                <input type="number" name="jumlah_dibayar" id="jumlah_dibayar" min="0" step="0.01" value="{{ $transaksi->jumlah_dibayar }}" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" onchange="hitungSisa()">
                <p class="text-xs text-gray-500 mt-1">*Kosongkan jika belum dibayar</p>
            </div>
            <div id="sisa_pembayaran_container">
                <label class="block text-sm font-semibold mb-1">Sisa Pembayaran</label>
                <input type="number" id="sisa_pembayaran" min="0" step="0.01" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none" readonly>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-200 focus:outline-none">{{ $transaksi->keterangan }}</textarea>
            </div>
            <div class="pt-2 flex gap-2">
                <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Update
                </button>
                <a href="{{ route('admin.transaksi') }}" class="w-full py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg shadow hover:bg-gray-300 transition flex items-center justify-center gap-2">Batal</a>
            </div>
        </form>
    </div>

    <script>
        function updateHewanOptions() {
            const selectedPelanggan = document.getElementById('pelanggan_id');
            const hewanSelect = document.getElementById('hewan_id');
            
            // Clear existing options
            hewanSelect.innerHTML = '<option value="">Pilih Hewan</option>';
            
            if (selectedPelanggan.value) {
                const selectedOption = selectedPelanggan.options[selectedPelanggan.selectedIndex];
                const hewans = JSON.parse(selectedOption.getAttribute('data-hewans') || '[]');
                
                if (hewans.length > 0) {
                    // Add new options
                    hewans.forEach(hewan => {
                        const option = document.createElement('option');
                        option.value = hewan.id;
                        option.textContent = `${hewan.nama} (${hewan.jenis})`;
                        hewanSelect.appendChild(option);
                    });
                } else {
                    // No hewans for this pelanggan
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = "Pelanggan ini belum memiliki hewan";
                    option.disabled = true;
                    hewanSelect.appendChild(option);
                }
            }
        }

        function handleLayananChange() {
            const jenisLayananCheckboxes = document.querySelectorAll('input[name="jenis_layanan[]"]:checked');
            const tanggalKeluarContainer = document.getElementById('tanggal_keluar_container');
            const durasiContainer = document.getElementById('durasi_container');
            const tanggalKeluar = document.getElementById('tanggal_keluar');
            
            let adaPenitipan = false;
            jenisLayananCheckboxes.forEach(checkbox => {
                if (checkbox.value === 'penitipan') {
                    adaPenitipan = true;
                }
            });
            
            // Tampilkan/sembunyikan field tanggal keluar dan durasi berdasarkan penitipan
            if (adaPenitipan) {
                tanggalKeluarContainer.style.display = 'block';
                durasiContainer.style.display = 'block';
                tanggalKeluar.required = false; // Tidak wajib, bisa kosong untuk 1 hari
            } else {
                tanggalKeluarContainer.style.display = 'none';
                durasiContainer.style.display = 'none';
                tanggalKeluar.value = ''; // Kosongkan tanggal keluar
                tanggalKeluar.required = false;
            }
            
            hitungTotal();
        }

        function handleTanggalChange() {
            const tanggalMasuk = document.getElementById('tanggal_masuk');
            const tanggalKeluar = document.getElementById('tanggal_keluar');
            const durasi = document.getElementById('durasi');
            
            if (tanggalMasuk.value) {
                // Set tanggal keluar default sama dengan tanggal masuk jika kosong
                if (!tanggalKeluar.value) {
                    tanggalKeluar.value = tanggalMasuk.value;
                }
                
                // Hitung durasi
                if (tanggalKeluar.value) {
                    const masuk = new Date(tanggalMasuk.value);
                    const keluar = new Date(tanggalKeluar.value);
                    const durasiHari = Math.ceil((keluar - masuk) / (1000 * 60 * 60 * 24));
                    durasi.value = durasiHari >= 0 ? durasiHari : 0;
                }
            }
            
            hitungTotal();
        }

        function hitungTotal() {
            const jenisLayananCheckboxes = document.querySelectorAll('input[name="jenis_layanan[]"]:checked');
            const tanggalMasuk = document.getElementById('tanggal_masuk');
            const tanggalKeluar = document.getElementById('tanggal_keluar');
            const durasi = document.getElementById('durasi');
            const totalHarga = document.getElementById('total_harga');
            
            let total = 0;
            let durasiHari = 1;
            let adaPenitipan = false;

            if (tanggalMasuk.value && jenisLayananCheckboxes.length > 0) {
                jenisLayananCheckboxes.forEach(checkbox => {
                    const hargaPerUnit = parseFloat(checkbox.getAttribute('data-harga'));
                    
                    if (checkbox.value === 'penitipan') {
                        adaPenitipan = true;
                        if (tanggalKeluar.value) {
                            // Hitung durasi untuk penitipan
                            const masuk = new Date(tanggalMasuk.value);
                            const keluar = new Date(tanggalKeluar.value);
                            durasiHari = Math.ceil((keluar - masuk) / (1000 * 60 * 60 * 24));
                            if (durasiHari < 1) durasiHari = 1;
                            total += hargaPerUnit * durasiHari;
                        } else {
                            // Jika belum ada tanggal keluar, hitung 1 hari
                            total += hargaPerUnit;
                        }
                    } else {
                        // Layanan lain (grooming, vaksinasi, checkup) = harga tetap
                        total += hargaPerUnit;
                    }
                });
                
                if (adaPenitipan) {
                    durasi.value = durasiHari;
                } else {
                    durasi.value = 0; // Tidak ada penitipan
                }
                totalHarga.value = total;
            } else {
                totalHarga.value = 0;
                durasi.value = 0;
            }
            
            // Hitung sisa pembayaran setelah total berubah
            hitungSisa();
        }

        function handleStatusPembayaranChange() {
            const statusPembayaran = document.getElementById('status_pembayaran');
            const jumlahDibayarContainer = document.getElementById('jumlah_dibayar_container');
            const sisaPembayaranContainer = document.getElementById('sisa_pembayaran_container');
            const jumlahDibayar = document.getElementById('jumlah_dibayar');
            const totalHarga = document.getElementById('total_harga');
            
            if (statusPembayaran.value === 'lunas') {
                jumlahDibayar.value = totalHarga.value;
                jumlahDibayar.readOnly = true;
                sisaPembayaranContainer.style.display = 'block';
            } else if (statusPembayaran.value === 'dp') {
                jumlahDibayar.readOnly = false;
                sisaPembayaranContainer.style.display = 'block';
            } else {
                jumlahDibayar.value = 0;
                jumlahDibayar.readOnly = false;
                sisaPembayaranContainer.style.display = 'none';
            }
            
            hitungSisa();
        }

        function hitungSisa() {
            const totalHarga = parseFloat(document.getElementById('total_harga').value) || 0;
            const jumlahDibayar = parseFloat(document.getElementById('jumlah_dibayar').value) || 0;
            const sisaPembayaran = document.getElementById('sisa_pembayaran');
            
            const sisa = totalHarga - jumlahDibayar;
            sisaPembayaran.value = sisa >= 0 ? sisa : 0;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            handleLayananChange();
            hitungTotal();
            handleStatusPembayaranChange();
            const statusPembayaran = document.getElementById('status_pembayaran');
            const jumlahDibayar = document.getElementById('jumlah_dibayar');
            const totalHarga = document.getElementById('total_harga');
            if (statusPembayaran.value === 'lunas') {
                jumlahDibayar.value = totalHarga.value;
            }
        });
    </script>
</body>
</html> 