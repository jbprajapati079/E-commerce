<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    // public function category()
    // {
    //     return $this->hasMany(Category::class, 'id', 'category_id');
    // }

    // public function brand()
    // {
    //     return $this->hasMany(Brand::class, 'id', 'brand_id');
    // }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
