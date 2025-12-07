<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'qty',
    ];

/*    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
*/
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

public function order()
{
    return $this->belongsTo(Order::class, 'order_id');
}

}
