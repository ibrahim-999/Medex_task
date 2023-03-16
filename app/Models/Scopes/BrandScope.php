<?php


use Illuminate\Database\Eloquent\Scope;

class BrandScope implements Scope
{
    public function apply(\Illuminate\Database\Eloquent\Builder $builder, \Illuminate\Database\Eloquent\Model $model, ...$brands)
    {
        return $builder
            ->whereIn('brand_id', $brands);
    }
}
