<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    use HasFactory;

    protected $table = "properties";

    protected $primaryKey = "property_id";

    protected $guarded = ['property_id'];

    protected $casts = [
        "specification" => "json",
        "galleries" => "json",
    ];

    protected $appends = [
        "thumbnail_url"
    ];


    public function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn() => $this->thumbnail ? asset(Storage::url($this->thumbnail))  : "");
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function location()
    {
        return $this->belongsTo(PropertyLocation::class, 'property_location_id');
    }

    public function type()
    {
        return $this->belongsTo(PropertyTypes::class, 'property_type_id');
    }

    public function typeSales()
    {
        return $this->belongsToMany(PropertyTypeSale::class, 'property_sale_types')->withTimestamps();
    }
}
