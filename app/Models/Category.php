<?php

namespace App\Models;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function Spiral\Tokenizer\Reflection\registerUse;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function isRoot(): bool
    {
        return $this->parent_id == null;
    }

    public function isParent(): bool
    {
        return $this->subcategories()->count() > 0;
    }

    public function isSubcategory(): bool
    {
        return $this->parent_id != null;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }
}
