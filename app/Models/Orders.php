<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'menu_id',
        'email',
        'fullname',
        'is_rice_menu',
        'is_add_ons_menu',
        'size',
        'is_served',
        'quantity',
        'price',
        'status',
        'reserved_at'
    ];
}
