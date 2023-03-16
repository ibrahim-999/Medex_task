<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\PaginatedCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = QueryBuilder::for(Category::class)
            ->defaultSort('-created_at')
            ->latest()
            ->paginate()
            ->withQueryString();

        $props = [
            'brands' => new PaginatedCollection($categories, CategoryResource::class),
        ];

        return view('category');
    }
}
