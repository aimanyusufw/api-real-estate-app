<?php

use App\Http\Controllers\PropertyController;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Models\PropertyLocation;
use App\Models\PropertyTypes;
use App\Models\PropertyTypeSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// property 
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{property}', [PropertyController::class, 'view']);

// property type
Route::get('/types', function () {
    return response()->json(["data" => PropertyTypes::latest()->get()]);
});
Route::get('/types/{propertyTypes}', function (PropertyTypes $propertyTypes) {
    return response()->json(["data" => $propertyTypes]);
});

// property location
Route::get('/locations', function () {
    return response()->json(["data" => PropertyLocation::latest()->get()]);
});
Route::get('/locations/{location}', function (PropertyLocation $location) {
    return response()->json(["data" => $location]);
});

// property sale type
Route::get('/type-sale', function () {
    return response()->json(["data" => PropertyTypeSale::latest()->get()]);
});
Route::get('/type-sale/{saleType}', function (PropertyTypeSale $saleType) {
    return response()->json(["data" => $saleType]);
});

// agents
Route::get('/agents', function () {
    return AgentResource::collection(Agent::latest()->get());
});
Route::get('/agents/{agent}', function (Agent $agent) {
    return new AgentResource($agent);
});
