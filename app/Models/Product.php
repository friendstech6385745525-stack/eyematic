<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;
    protected $fillable = [
      'category_id','brand_id','name','slug','description','price','discount','stock','images'
    ];
    protected $casts = [
      'images' => 'array',
      'price' => 'decimal:2',
      'discount' => 'decimal:2'
    ];

    public function category(){ return $this->belongsTo(Category::class); }
    public function brand(){ return $this->belongsTo(Brand::class); }
    public function user()     { return $this->belongsTo(\App\Models\User::class); }
}
