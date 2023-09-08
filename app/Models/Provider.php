<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'eng_name',
        'image',
        'whatsapp',
        'phone',
        'address',
        'instagram',
        'facebook',
        'twitter',
        'theme',
        'opened_from',
        'opened_to',
        'is_active',
        'url',
        'tables',
        'discount',
        'longitude',
        'latitude',
        'google_map_link',
        'tiktok',
        'snapchat',
    ];

}
