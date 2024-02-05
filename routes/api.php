<?php

use App\Http\Controllers\Api\AssemblyController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\User\UserAssemblyController;
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

Route::apiResource('components', ComponentController::class)->only('index', 'show');
Route::apiResource('assemblies', AssemblyController::class)->only('index', 'show');

Route::group(['middleware' => ['guest']], function () {
    Route::post('/login', [LoginController::class, 'store'])->name('login');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('user/assembly/{assembly}', [UserAssemblyController::class, 'store'])->name('user.assembly.store');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('manufacturers/options', [ManufacturerController::class, 'getOptions'])->name('manufacturers.options');
    Route::get('components/options', [ComponentController::class, 'getOptions'])->name('components.options');

    Route::apiResource('components', ComponentController::class)->only('store', 'update');
    Route::apiResource('assemblies', AssemblyController::class)->only('store', 'update');
});
