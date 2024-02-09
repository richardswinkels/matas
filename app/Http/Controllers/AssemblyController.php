<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssemblyController extends Controller
{
    public function index(): View
    {
        return view('assemblies.index');
    }

    public function create(): View
    {
        return view('assemblies.create');
    }

    public function show(Assembly $assembly): View
    {
        $assembly->load('components');

        return view('assemblies.show', ['assembly' => $assembly]);
    }

    public function edit(Assembly $assembly): View
    {
        $assembly->load('components');

        return view('assemblies.edit', ['assembly' => $assembly]);
    }
}
