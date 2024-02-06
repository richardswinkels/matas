<?php

use App\Http\Controllers\Api\AssemblyController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\ManufacturerController;
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

Route::apiResource('components', ComponentController::class)->only('index');
Route::apiResource('assemblies', AssemblyController::class)->only('index');

Route::group(['middleware' => ['auth.admin']], function () {
    Route::apiResource('components', ComponentController::class)->only('store', 'update');
    Route::apiResource('assemblies', AssemblyController::class)->only('store', 'update');
});
