<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use Illuminate\Http\Request;

class AssemblyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('assemblies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('assemblies.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assembly $assembly)
    {
        $assembly->load('components');

        return view('assemblies.show', ['assembly' => $assembly]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assembly $assembly)
    {
        $assembly->load('components');

        return view('assemblies.edit', ['assembly' => $assembly]);
    }
}
