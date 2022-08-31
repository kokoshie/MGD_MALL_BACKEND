<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'item_code',
        'item_name',
        'color',
        'size',
        'price',
        'photo'
    ];
}
