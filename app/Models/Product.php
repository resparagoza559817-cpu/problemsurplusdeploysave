<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    public $timestamps = false; 

    protected $fillable = ['name', 'price', 'stock', 'description', 'image_path', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Fix for Broken Images: Create the image_url property[cite: 8]
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/default-product.png'); // Fallback if no image exists
    }
}