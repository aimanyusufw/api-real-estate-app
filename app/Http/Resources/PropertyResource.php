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
            'agent' => [
                'id' => $this->agent->id,
                'name' => $this->agent->name,
                'profile_picture' => asset(Storage::url($this->agent->profile_picture)),
                'email' => $this->agent->email,
                'phone' => $this->agent->phone,
            ],
            'thumbnail' => $this->thumbnail_url,
            'location' => [
                'name' => $this->location->name,
                'slug' => $this->location->slug,
            ],
            'type' => [
                'name' => $this->type->name,
                'slug' => $this->type->slug,
            ],
            'type_sale' => $this->typeSales->map(function ($typeSale) {
                return [
                    'name' => $typeSale->name,
                    'slug' => $typeSale->slug,
                ];
            }),
            'price' => [
                "string" => 'Rp ' . number_format($this->price, 0, ',', '.'),
                "int" => $this->price
            ],
            'short_description' => $this->short_description,
            'description_title' => $this->description_title,
            'specification' => $this->specification,
            'galleries' => collect($this->galleries)->map(function ($gallery) {
                return ["image" => asset(Storage::url($gallery['image']))];
            }),
            'description' => $this->description,
        ];
    }
}
