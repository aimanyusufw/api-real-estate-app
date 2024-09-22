<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyCollection;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Resources\PropertyResource;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PropertyController extends Controller
{
    public function index()
    {
        request()->validate([
            'limit' => 'integer|min:1|max:100',
            'location' => 'nullable|string',
            'query' => 'nullable|string',
            'type' => 'nullable|string',
            'type_sale' => 'nullable|string',
            'bedroom' => 'nullable|integer',
            'agent_id' => 'nullable|integer',
        ]);


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
                    $typeQuery->where('id', $agent);
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


        if ($data->isEmpty()) {
            return response()->json([
                'isError' => 'ture',
                'statusCode' => 404,
                'message' => 'Data not found',
            ], 404);
        }


        return new PropertyCollection($data);
    }



    public function view(Property $property)
    {
        return new PropertyResource($property->load('agent', 'location', 'type', 'typeSales'));
    }
}
