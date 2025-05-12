<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $table = 'mutasi'; // Nama tabel database yang digunakan

    protected $fillable = [
        'idstok', 'qty', 'user_id', 'ket', 'nobukti', 'mk', 'date', 'status'
    ];
}
