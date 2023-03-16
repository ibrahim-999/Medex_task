<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Spatie\MediaLibrary\getFirstMediaUrl;
use function Spatie\MediaLibrary\getMedia;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'           => $this->name,
            'barcode'           => $this->barcode,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'short_description'            => $this->short_description,
            'long_description'            => $this->long_description,
            'subcategory_id'     => $this->subcategory_id,
            'brand_id'     => $this->brand_id,
            'image' => getFirstMediaUrl('image','main')
        ];
    }
}
