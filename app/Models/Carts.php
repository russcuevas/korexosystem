<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'menu_id',
        'is_rice_menu',
        'is_add_ons_menu',
        'size',
        'quantity',
        'price',
    ];
}
