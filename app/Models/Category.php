<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Automatically cast attributes.
     *
     * @var array<string,string>
     */
    protected $casts = [
        // Add casts if you add JSON columns later, e.g. 'meta' => 'array'
    ];

    /**
     * Boot the model and create slug when creating/updating.
     */
    protected static function booted()
    {
        static::saving(function (Category $category) {
            // generate slug if not provided
            if (empty($category->slug) && ! empty($category->name)) {
                $candidate = Str::slug($category->name);
                // ensure uniqueness by appending id/uniq if needed
                $original = $candidate;
                $i = 1;
                while (static::where('slug', $candidate)
                    ->when($category->exists, fn($q) => $q->where('id', '!=', $category->id))
                    ->exists()) {
                    $candidate = $original . '-' . $i++;
                }
                $category->slug = $candidate;
            }
        });
    }

    /**
     * Use slug for route model binding (optional but convenient).
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Category has many products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
