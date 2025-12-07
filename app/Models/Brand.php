<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted()
    {
        static::saving(function (Brand $brand) {
            if (empty($brand->slug) && ! empty($brand->name)) {
                $candidate = Str::slug($brand->name);
                $original = $candidate;
                $i = 1;
                while (static::where('slug', $candidate)
                    ->when($brand->exists, fn($q) => $q->where('id', '!=', $brand->id))
                    ->exists()) {
                    $candidate = $original . '-' . $i++;
                }
                $brand->slug = $candidate;
            }
        });
    }

    /**
     * Use slug for route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Brand has many products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
