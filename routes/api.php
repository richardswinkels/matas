<?php

use App\Http\Controllers\Api\Assembly\AssemblyComponentController;
use App\Http\Controllers\Api\AssemblyController;
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

Route::apiResource('components', ComponentController::class)->only('index');
Route::apiResource('assemblies', AssemblyController::class)->only('index');

Route::group(['middleware' => ['auth']], function (){
    Route::get('user/assemblies', [UserAssemblyController::class, 'index'])->name('user.assemblies.index');
    Route::post('user/assemblies/{assembly}', [UserAssemblyController::class, 'store'])->name('user.assemblies.store');
});

Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('manufacturers', [ManufacturerController::class, 'index'])->name('manufacturers.index');

    Route::apiResource('components', ComponentController::class)->only('store', 'update');
    Route::apiResource('assemblies', AssemblyController::class)->only('store', 'update');

    Route::post('assemblies/{assembly}/components/{component}', [AssemblyComponentController::class, 'store'])->name('assembly.components.store');
    Route::get('assemblies/{assembly}/components', [AssemblyComponentController::class, 'show'])->name('assembly.components.show');
    Route::delete('assemblies/{assembly}/components/{component}', [AssemblyComponentController::class, 'destroy'])->name('assembly.components.destroy');
});
