<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->string('name');
            $table->text('short_description');
            $table->longText('long_description');
            $table->integer('price')->default(0);
            $table->integer('quantity');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();

            $table->foreignId('subcategory_id')
                ->nullable()
                ->references('id')
                ->on('categories')
                ->cascadeOnDelete();

            $table->foreignId('brand_id')
                ->nullable()
                ->references('id')
                ->on('brands')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
