<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'description',
        'images',
        'data',
        'position'
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
