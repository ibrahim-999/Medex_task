<?php

namespace App\Models;

use BrandScope;
use Carbon\Carbon;
use CategoryScope;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use HasMedia;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Magazine\Entities\ProductView;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use SubcategoryScope;
use Viewable;

class Product extends Model
{
    use HasFactory;
    use InteractsWithMedia;

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

    public function views(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(ProductView::class, 'viewable');
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('main')
            ->keepOriginalImageFormat()
            ->performOnCollections('image');
    }

    public function scopeInSubCategory($query, ...$subcategories)
    {
        return $query->whereIn('subcategory_id', $subcategories);
    }

    public function scopeInCategory($query, ...$categories)
    {
        $query->whereHas('subcategory', function ($query) use ($categories) {
            return $query->whereIn('parent_id', $categories);
        });
    }

    public function scopeInBrand($query, ...$brands)
    {
        return $query->whereIn('brand_id', $brands);
    }

    public static function scopeTrending(Builder $query): Builder
    {
        $lastMonth = Carbon::now()->subMonth();

        return $query
            ->leftJoinSub(
                ProductView::whereViewableType(static::class)->whereMonth('month', $lastMonth),
                'views',
                'products.id',
                '=',
                'views.viewable_id'
            )
            ->orderBy('views.count', 'desc')
            ->select('products.*');
    }
}
