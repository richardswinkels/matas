<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManufacturerResource;
use App\Models\Manufacturer;

class ManufacturerController extends Controller
{
    /**
     * Return select options array.
     */
    public function getOptions()
    {
        $manufacturers = Manufacturer::all();

        return ManufacturerResource::collection($manufacturers);
    }
}
