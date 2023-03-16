<?php

namespace App\Models;

use BrandScope;
use CategoryScope;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SubcategoryScope;

class Product extends Model
{
    use HasFactory;
    use HasMedia;

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

    public function scopeInMinPrice($query, $minPrice)
    {
        $minPrice *= 100;
            return $query
                ->where('price', '>=', $minPrice);
    }

    public function scopeInMaxPrice($query, $maxPrice)
    {
        $maxPrice *= 100;
            return $query
                ->where('price', '<=', $maxPrice);
    }

    public function similarProducts($query)
    {
        $parentCategory = $this->subcategory->parent_id;

        return $query
            ->whereHas('subcategory', function ($query) use ($parentCategory) {
            $query
                ->where('parent_id', $parentCategory);
        })
            ->where('id', '!=', $this->id);
    }
}
