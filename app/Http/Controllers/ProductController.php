<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginatedCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function index()
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
}
