<?php

namespace Database\Seeders;

use App\Models\ProductOffer;
use App\Models\ProductView;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductView::factory()->count(10)->create();

    }
}
