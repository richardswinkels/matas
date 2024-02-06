<?php

namespace App\Http\Controllers;

use App\Models\Component;
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
        return view('components.create');
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
        return view('components.edit', ['component' => $component]);
    }
}
