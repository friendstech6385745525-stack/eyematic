<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'price',
    ];

    // 🧩 Each cart item belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🧩 Each cart item belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 🧩 Helper: Calculate total per item
    public function getTotalAttribute()
    {
        return $this->price * $this->qty;
    }
}
