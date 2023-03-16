<?php

namespace App\Models;

use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }
}
