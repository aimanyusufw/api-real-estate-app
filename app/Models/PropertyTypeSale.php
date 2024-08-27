<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyTypeSale extends Model
{
    use HasFactory;

    protected $table = "sale_types";

    protected $primaryKey = "sale_type_id";

    protected $guarded = ['sale_type_id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_sale_types')->withTimestamps();
    }
}
