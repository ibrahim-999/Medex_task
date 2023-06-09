<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ProductFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime'
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

    public function offers()
    {
        return $this
            ->belongsToMany(Offer::class, 'product_offers')
            ->withPivot('price')
            ->using(ProductOffer::class);
    }

    public function scopeInMinPrice($query, $minPrice)
    {
        $minPrice *= 100;
            return $query
                ->where('price', '>=', $minPrice)
                ->orWhereHas('offers', function ($q) use ($minPrice) {
                return $q
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->where('price', '>=', $minPrice);
            });
    }

    public function scopeInMaxPrice($query, $maxPrice)
    {
        $maxPrice *= 100;
            return $query
                ->where('price', '<=', $maxPrice)
                ->orWhereHas('offers', function ($q) use ($maxPrice) {
                return $q
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->where('price', '<=', $maxPrice);
            });
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
            ->where('products.published_at', '<=', Carbon::now())
            ->orderBy('views.count', 'desc')
            ->select('products.*');
    }

    public static function scopeRecent(Builder $query): Builder
    {
        return $query
            ->where('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc');
    }

    public function scopeIsOffer($query)
    {
        $query
            ->whereHas('offers', function ($q) {
            return $q
                ->where('start_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now());
        });
    }

}
