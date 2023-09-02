<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'open_to',
        'open_from',
        'longitude',
        'latitude',
        'open24',
    ];

}
