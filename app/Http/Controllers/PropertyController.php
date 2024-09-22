<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyCollection;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;

class PropertyController extends Controller
{
    public function index()
    {
        $dataPerPage = request('limit', 10);
        $location = request('location');
        $query = request('query');
        $type = request('type');
        $typeSale = request('type_sale');
        $bedroom = request('bedroom');
        $agent = request('agent_id');

        $data = Property::with('location', 'type', 'typeSales')
            ->latest()
            ->when($query, function ($q) use ($query) {
                $q->where(function ($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%")
                        ->orWhereHas('location', function ($authorQuery) use ($query) {
                            $authorQuery->where('name', 'LIKE', "%{$query}%");
                        })
                        ->orWhereHas('type', function ($tagsQuery) use ($query) {
                            $tagsQuery->where('name', 'LIKE', "%{$query}%");
                        });
                });
            })
            ->when($location, function ($q) use ($location) {
                $q->whereHas('location', function ($loc) use ($location) {
                    $loc->where('slug', 'LIKE', "%{$location}%");
                });
            })
            ->when($type, function ($q) use ($type) {
                $q->whereHas('type', function ($typeQuery) use ($type) {
                    $typeQuery->where('slug', 'LIKE', "%{$type}%");
                });
            })
            ->when($agent, function ($q) use ($agent) {
                $q->whereHas('agent', function ($typeQuery) use ($agent) {
                    $typeQuery->where('id', 'LIKE', "%{$agent}%");
                });
            })
            ->when($typeSale, function ($query) use ($typeSale) {
                $query->whereHas('typeSales', function ($typeSaleQuery) use ($typeSale) {
                    $typeSaleQuery->where('slug', 'LIKE', "%{$typeSale}%");
                });
            })
            ->when($bedroom, function ($query) use ($bedroom) {
                $query->whereJsonContains('specification->bedroom', $bedroom);
            })
            ->paginate($dataPerPage);

        return new PropertyCollection($data);
    }



    public function view(Property $property)
    {
        return new PropertyResource($property->load('agent', 'location', 'type', 'typeSales'));
    }
}
