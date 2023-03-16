<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'short_description',
        'long_description',
        'price',
        'quantity',
        'subcategory_id',
        'brand_id',
    ];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
