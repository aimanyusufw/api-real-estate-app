<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->property_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'agent' => $this->agent ? [
                'id' => $this->agent->id,
                'name' => $this->agent->name,
                'profile_picture' => $this->agent->profile_picture ? asset(Storage::url($this->agent->profile_picture)) : null,
                'email' => $this->agent->email,
                'phone' => $this->agent->phone,
            ] : null,
            'thumbnail' => $this->thumbnail_url,
            'location' => $this->location ? [
                'name' => $this->location->name,
                'slug' => $this->location->slug,
            ] : null,
            'type' => $this->type ? [
                'name' => $this->type->name,
                'slug' => $this->type->slug,
            ] : null,
            'type_sale' => $this->typeSales ? $this->typeSales->map(function ($typeSale) {
                return [
                    'name' => $typeSale->name,
                    'slug' => $typeSale->slug,
                ];
            }) : null,
            'price' => [
                "string" => 'Rp ' . number_format($this->price, 0, ',', '.'),
                "int" => $this->price,
            ],
            'short_description' => $this->short_description,
            'description_title' => $this->description_title,
            'specification' => $this->specification,
            'galleries' => $this->galleries ? collect($this->galleries)->map(function ($gallery) {
                return ["image" => $gallery['image'] ? asset(Storage::url($gallery['image'])) : null];
            }) : [],
            'description' => $this->description,
            'related_properties' => $this->relatedProperties()->map(function ($property) {
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
