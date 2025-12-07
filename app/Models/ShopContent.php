<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopContent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
    ];
}
