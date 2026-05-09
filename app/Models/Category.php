<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Allows us to save the category name
    protected $fillable = ['name'];

    // This tells Laravel: "One category can have many products"
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}