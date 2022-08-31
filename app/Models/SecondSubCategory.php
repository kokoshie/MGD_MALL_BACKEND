<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondSubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'subcategory_id',
        'second_name'
    ];
}
