<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyTypes extends Model
{
    use HasFactory;

    protected $primaryKey = 'property_type_id';

    protected $table = "property_types";

    protected $guarded = ['property_type_id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
