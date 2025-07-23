<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'email', 'telepon', 'password'];

    public function hewans()
    {
        return $this->hasMany(HewanPeliharaan::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
