<?php


use Illuminate\Database\Eloquent\Scope;

class SubcategoryScope implements Scope
{
    public function apply(\Illuminate\Database\Eloquent\Builder $builder, \Illuminate\Database\Eloquent\Model $model, ...$subcategories)
    {
        return $builder
            ->whereIn('subcategory_id', $subcategories);
    }

    public function scopeInCategory($query, ...$categories)
    {
        $query
            ->whereHas('subcategory', function ($query) use ($categories) {
                return $query
                    ->whereIn('parent_id', $categories);
            });
    }

    public function scopeInBrand($query, ...$brands)
    {
        return $query
            ->whereIn('brand_id', $brands);
    }
}
