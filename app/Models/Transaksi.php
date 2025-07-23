<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'pelanggan_id',
        'hewan_id',
        'jenis_layanan',
        'tanggal_masuk',
        'tanggal_keluar',
        'total_harga',
        'metode_pembayaran',
        'status_pembayaran',
        'jumlah_dibayar',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
        'total_harga' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'jenis_layanan' => 'array'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function hewan()
    {
        return $this->belongsTo(\App\Models\HewanPeliharaan::class, 'hewan_id');
    }
    public function layanan()
    {
        return $this->belongsTo(\App\Models\Layanan::class, 'jenis_layanan', 'nama');
    }
} 