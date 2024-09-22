<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($property) {
                return [
                    'title' => $property->title,
                    'slug' => $property->slug,
                    'thumbnail' => $property->thumbnail_url,
                    'location' => $property->location ? [
                        'name' => $property->location->name,
                        'slug' => $property->location->slug,
                    ] : null,
                    'type' => $property->type ? [
                        'name' => $property->type->name,
                        'slug' => $property->type->slug,
                    ] : null,
                    'price' => [
                        "string" => 'Rp ' . number_format($property->price, 0, ',', '.'),
                        "int" => $property->price,
                    ],
                    'description_title' => $property->description_title,
                    'specification' => $property->specification,
                ];
            })
        ];
    }
}
