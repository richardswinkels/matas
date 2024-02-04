<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManufacturerResource;
use App\Models\Manufacturer;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manufacturers = Manufacturer::all();

        return ManufacturerResource::collection($manufacturers);
    }
}