<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'en_name',
        'image',
        'details',
        'en_details',
        'is_active',
        'position',
        'price',
        'category_id',
        'provider_id',
    ];
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
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
