<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        Layanan::insert([
            [
                'nama' => 'Penitipan',
                'harga' => 100000,
                'durasi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Grooming',
                'harga' => 50000,
                'durasi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Vaksinasi',
                'harga' => 75000,
                'durasi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Checkup',
                'harga' => 120000,
                'durasi' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 