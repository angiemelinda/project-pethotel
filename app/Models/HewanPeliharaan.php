<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HewanPeliharaan extends Model
{
    use HasFactory;

    protected $table = 'hewan_peliharaans';

    protected $fillable = [
        'nama',
        'jenis',
        'ras',
        'usia',
        'pelanggan_id',
        'status_vaksin'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'hewan_id');
    }
}
