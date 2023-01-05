<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;


      protected $fillable = [
        'Product_name',
        'Product_Category',
        'Product_Description',
        'Product_Per_Price',
        'Product_Available_Qty',
        'user_id',
        'Product_status',
        'Product_Image',
    ];
}
