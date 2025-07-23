<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use App\Models\HewanPeliharaan;
use App\Models\Transaksi;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Pelanggan
        $pelanggan1 = Pelanggan::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'telepon' => '081234567890',
            'password' => bcrypt('password123')
        ]);

        $pelanggan2 = Pelanggan::create([
            'nama' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'telepon' => '081234567891',
            'password' => bcrypt('password123')
        ]);

        $pelanggan3 = Pelanggan::create([
            'nama' => 'Ahmad Rizki',
            'email' => 'ahmad@example.com',
            'telepon' => '081234567892',
            'password' => bcrypt('password123')
        ]);

        // Create Hewan Peliharaan
        $hewan1 = HewanPeliharaan::create([
            'nama' => 'Milo',
            'jenis' => 'anjing',
            'ras' => 'Golden Retriever',
            'usia' => 3,
            'pelanggan_id' => $pelanggan1->id,
            'status_vaksin' => 'vaccinated'
        ]);

        $hewan2 = HewanPeliharaan::create([
            'nama' => 'Luna',
            'jenis' => 'kucing',
            'ras' => 'Persian',
            'usia' => 2,
            'pelanggan_id' => $pelanggan1->id,
            'status_vaksin' => 'vaccinated'
        ]);

        $hewan3 = HewanPeliharaan::create([
            'nama' => 'Rocky',
            'jenis' => 'anjing',
            'ras' => 'German Shepherd',
            'usia' => 4,
            'pelanggan_id' => $pelanggan2->id,
            'status_vaksin' => 'partial'
        ]);

        $hewan4 = HewanPeliharaan::create([
            'nama' => 'Whiskers',
            'jenis' => 'kucing',
            'ras' => 'Maine Coon',
            'usia' => 1,
            'pelanggan_id' => $pelanggan3->id,
            'status_vaksin' => 'not_vaccinated'
        ]);

        // Create Transaksi
        Transaksi::create([
            'pelanggan_id' => $pelanggan1->id,
            'hewan_id' => $hewan1->id,
            'jenis_layanan' => 'penitipan',
            'tanggal_masuk' => '2024-01-15',
            'tanggal_keluar' => '2024-01-20',
            'total_harga' => 500000,
            'status' => 'completed',
            'keterangan' => 'Penitipan anjing selama 5 hari'
        ]);

        Transaksi::create([
            'pelanggan_id' => $pelanggan1->id,
            'hewan_id' => $hewan2->id,
            'jenis_layanan' => 'grooming',
            'tanggal_masuk' => '2024-01-18',
            'tanggal_keluar' => '2024-01-18',
            'total_harga' => 150000,
            'status' => 'completed',
            'keterangan' => 'Grooming kucing persian'
        ]);

        Transaksi::create([
            'pelanggan_id' => $pelanggan2->id,
            'hewan_id' => $hewan3->id,
            'jenis_layanan' => 'vaksinasi',
            'tanggal_masuk' => '2024-01-20',
            'tanggal_keluar' => '2024-01-20',
            'total_harga' => 200000,
            'status' => 'process',
            'keterangan' => 'Vaksinasi rabies'
        ]);

        Transaksi::create([
            'pelanggan_id' => $pelanggan3->id,
            'hewan_id' => $hewan4->id,
            'jenis_layanan' => 'checkup',
            'tanggal_masuk' => '2024-01-22',
            'tanggal_keluar' => '2024-01-22',
            'total_harga' => 100000,
            'status' => 'pending',
            'keterangan' => 'Checkup kesehatan rutin'
        ]);

        $this->command->info('Test data berhasil dibuat!');
        $this->command->info('- 3 Pelanggan');
        $this->command->info('- 4 Hewan Peliharaan');
        $this->command->info('- 4 Transaksi');
    }
}
