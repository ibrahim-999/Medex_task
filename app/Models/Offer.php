<?php

namespace App\Models;

use Database\Factories\OfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'end_date' => 'datetime:Y-m-d H:00',
        'start_date' => 'datetime:Y-m-d H:00',
    ];

    public function products()
    {
        return $this
            ->belongsToMany( Product::class, 'product_offers')
            ->withPivot('price')
            ->using(ProductOffer::class);
    }

    protected static function newFactory(): OfferFactory
    {
        return OfferFactory::new();
    }
}
