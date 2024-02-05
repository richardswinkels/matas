<?php

use App\Http\Controllers\ComponentController;
use App\Http\Controllers\AssemblyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return redirect()->route('components.index');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login')->name('login');
    Route::post('/login');
    Route::get('/register')->name('register');
    Route::post('/register');
});

Route::group(['middleware' => 'auth'], function () {
    Route::delete('/logout');
});

Route::group(['middleware' => 'auth.admin'], function () {
    Route::resource('assemblies', AssemblyController::class)->only('create', 'edit');
    Route::resource('components', ComponentController::class)->only('create', 'edit');
});

Route::resource('assemblies', AssemblyController::class)->only('index', 'show');
Route::resource('components', ComponentController::class)->only('index', 'show');
