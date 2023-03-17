<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Libraries\ApiResponse;
use App\Models\Brand;

class BrandApiController extends Controller
{
    public function index()
    {
        return ApiResponse::success([
            'brands' => BrandResource::collection(Brand::paginate())
        ]);
    }
}
