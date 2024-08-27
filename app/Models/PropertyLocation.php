<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyLocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'property_location_id';

    protected $table = "property_locations";

    protected $guarded = ["property_location_id"];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
