<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Quan hệ với bảng products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}