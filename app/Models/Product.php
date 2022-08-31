<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'sec_sub_category_id',
        'product_code',
        'product_name',
        'description',
        'long_description',
        'video_link'
    ];
}
