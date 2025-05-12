<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'tbstok';
    protected $fillable = [
        'nama', 'harga', 'desc','kode','foto'
    ];

    // Relasi dengan tabel carts (keranjang)
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
