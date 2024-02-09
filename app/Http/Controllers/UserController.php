<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserController extends Controller
{
    public function show(): View
    {
        return view('users.show');
    }
}
