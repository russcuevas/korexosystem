<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'menu_pic',
        'menu_name',
        'menu_price',
        'ingredients',
        'stock_number',
        'is_rice_menu',
        'is_add_ons_menu',
        'status',
    ];
}
