<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Staff;

class AdminStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        Admin::create([
            'nama' => 'Super Admin',
            'email' => 'admin@pethotel.com',
            'telepon' => '081234567890',
            'password' => bcrypt('admin123')
        ]);

        Admin::create([
            'nama' => 'Admin Manager',
            'email' => 'manager@pethotel.com',
            'telepon' => '081234567891',
            'password' => bcrypt('manager123')
        ]);

        // Create Staff
        Staff::create([
            'nama' => 'Staff Grooming',
            'email' => 'staff@pethotel.com',
            'telepon' => '081234567892',
            'jabatan' => 'Groomer',
            'password' => bcrypt('staff123')
        ]);

        Staff::create([
            'nama' => 'Staff Penitipan',
            'email' => 'penitipan@pethotel.com',
            'telepon' => '081234567893',
            'jabatan' => 'Pet Sitter',
            'password' => bcrypt('penitipan123')
        ]);

        Staff::create([
            'nama' => 'Staff Medis',
            'email' => 'medis@pethotel.com',
            'telepon' => '081234567894',
            'jabatan' => 'Veterinarian',
            'password' => bcrypt('medis123')
        ]);

        $this->command->info('Admin dan Staff berhasil dibuat!');
        $this->command->info('=== ADMIN ===');
        $this->command->info('Email: admin@pethotel.com | Password: admin123');
        $this->command->info('Email: manager@pethotel.com | Password: manager123');
        $this->command->info('=== STAFF ===');
        $this->command->info('Email: staff@pethotel.com | Password: staff123');
        $this->command->info('Email: penitipan@pethotel.com | Password: penitipan123');
        $this->command->info('Email: medis@pethotel.com | Password: medis123');
    }
} 