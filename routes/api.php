<?php

use App\Http\Controllers\Api\AssemblyController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\ManufacturerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('manufacturers/options', [ManufacturerController::class, 'getOptions'])->name('manufacturers.options');
Route::get('components/options', [ComponentController::class, 'getOptions'])->name('components.options');

Route::apiResource('components', ComponentController::class);
Route::apiResource('assemblies', AssemblyController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
