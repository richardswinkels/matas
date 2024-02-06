<?php

namespace App\Http\Controllers;

use App\Http\Resources\ManufacturerResource;
use App\Models\Component;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('components.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manufacturers = ManufacturerResource::collection(Manufacturer::all());

        return view('components.create', ['manufacturers' => $manufacturers]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Component $component)
    {
        $component->load('manufacturer');

        return view('components.show', ['component' => $component]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Component $component)
    {
        $component->load('manufacturer');

        return view('components.edit', ['component' => $component]);
    }
}
