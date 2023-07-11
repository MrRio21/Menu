<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable =[
        'provider_id',
        'category_name',
        'en_category_name',
        'logo',
        'position',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
