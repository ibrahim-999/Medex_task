<?php


use Illuminate\Database\Eloquent\Scope;

class CategoryScope implements Scope
{
    public function apply(\Illuminate\Database\Eloquent\Builder $builder, \Illuminate\Database\Eloquent\Model $model, ...$categories)
    {
        $builder
            ->whereHas('subcategory', function ($query) use ($categories) {
                return $query
                    ->whereIn('parent_id', $categories);
            });
    }
}
