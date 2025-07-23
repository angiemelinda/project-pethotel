<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $fillable = ['nama', 'email', 'telepon', 'jabatan', 'password'];
} 