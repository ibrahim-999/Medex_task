<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Http\Resources\PaginatedCollection;
use App\Models\Brand;
use Spatie\QueryBuilder\QueryBuilder;

class BrandController extends Controller
{
    public function index()
    {
        $brands = QueryBuilder::for(Brand::class)
            ->defaultSort('-created_at')
            ->latest()
            ->paginate()
            ->withQueryString();

        $props = [
            'brands' => new PaginatedCollection($brands, BrandResource::class),
        ];

        return view('brand');
    }
}
