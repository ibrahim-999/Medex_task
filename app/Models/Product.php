<?php

namespace App\Models;

use BrandScope;
use CategoryScope;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SubcategoryScope;

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

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new CategoryScope);
        static::addGlobalScope(new BrandScope);
        static::addGlobalScope(new SubcategoryScope);
    }


}
