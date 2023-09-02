<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'details',
        'is_active',
        'position',
        'price',
        'calories',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function productOptions()
    {
        return $this->hasMany(ProductOption::class);
    }

    public function productOptions2()
    {
        return $this->hasMany(ProductOption2::class);
    }
}
