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
        'position',
        'background_image',
        'background_video'
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
