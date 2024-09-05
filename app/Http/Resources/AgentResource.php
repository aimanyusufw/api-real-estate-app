<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AgentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'profile_picture' => asset(Storage::url($this->profile_picture)),
            'phone' => $this->phone,
            'email' => $this->email,
            'social_media_links' => $this->social_media_links,
            'description' => $this->description,
            'total_property' => $this->total_property,
            'total_sold_property' => $this->total_sold_property,
            'price_range_property' => $this->price_range_property,
            'joined_date' => [
                "date" => $this->joined_date,
                "string" => $this->joined_date->diffForHumans(),
                "year" => date("Y", strtotime($this->joined_date))
            ],
        ];
    }
}
