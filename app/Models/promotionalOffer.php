<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promotionalOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'is_active'
    ];
}
