<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManufacturerResource;
use App\Models\Component;
use App\Models\Manufacturer;
use Illuminate\View\View;

class ComponentController extends Controller
{
    public function index(): View
    {
        return view('components.index');
    }

    public function create(): View
    {
        $manufacturers = ManufacturerResource::collection(Manufacturer::all());

        return view('components.create', ['manufacturers' => $manufacturers]);
    }

    public function show(Component $component): View
    {
        $component->load('manufacturer');

        return view('components.show', ['component' => $component]);
    }

    public function edit(Component $component): View
    {
        $component->load('manufacturer');

        return view('components.edit', ['component' => $component]);
    }
}
