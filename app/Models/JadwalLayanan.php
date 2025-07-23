<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalLayanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'hewan_id', 'layanan_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'status', 'keterangan', 'created_at', 'updated_at'
    ];

    public function hewan()
    {
        return $this->belongsTo(HewanPeliharaan::class, 'hewan_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
} 