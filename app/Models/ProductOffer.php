<?php

namespace App\Models;

use Database\Factories\ProductOfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'product_offers';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    protected static function newFactory(): ProductOfferFactory
    {
        return ProductOfferFactory::new();
    }
}
