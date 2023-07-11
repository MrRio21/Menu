<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bills extends Model
{
    use HasFactory;
    protected $fillable =[
        'customer_name',
        'customer_address',
        'customer_phone',
        'order_details',
        'bill_total'
    ];
}
