<?php

namespace Modules\Magazine\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

class ProductView extends Model
{
    use HasFactory;

    protected $fillable = [
        'viewable_id',
        'viewable_type',
        'count',
        'month'
    ];

    protected $casts = [
        'month' => 'date:m-Y',
    ];

    protected static function newFactory() : ProductViewFactory
    {
        return ProductViewFactory::new();
    }

    public function viewable() : MorphTo
    {
        return $this->MorphTo();
    }

    public static function scopeCurrentMonth($query)
    {
        return $query->whereMonth('month', Carbon::now());
    }
}
