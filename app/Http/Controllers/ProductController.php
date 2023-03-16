<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginatedCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Spatie\QueryBuilder\QueryBuilder;
use function Termwind\ValueObjects\pr;

class ProductController extends Controller
{
    public function trendingProducts()
    {
        $trendyProducts = QueryBuilder::for(Product::class)
            ->trending()
            ->defaultSort('-created_at')
            ->paginate()
            ->withQueryString();

        $props = [
            'products' => new PaginatedCollection($trendyProducts, ProductResource::class),
        ];

        return view('product');
    }

    public function recentProducts()
    {
        $recentProducts = QueryBuilder::for(Product::class)
            ->recent()
            ->defaultSort('-created_at')
            ->paginate()
            ->withQueryString();

        $props = [
            'products' => new PaginatedCollection($recentProducts, ProductResource::class),
        ];

        return view('product');
    }
}
