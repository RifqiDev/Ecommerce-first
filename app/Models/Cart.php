<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'quantity'
    ];

    // Relasi dengan tabel products
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi dengan tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
