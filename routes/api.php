<?php

use App\Http\Controllers\Api\Assembly\AssemblyComponentController;
use App\Http\Controllers\Api\AssemblyController;
use App\Http\Controllers\Api\ComponentController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\User\BuyAssemblyController;
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

Route::apiResource('components', ComponentController::class)->only('index'); // done
Route::apiResource('assemblies', AssemblyController::class)->only('index'); // done

Route::group(['middleware' => ['auth']], function (){
    Route::get('user/assemblies', [UserAssemblyController::class, 'index'])->name('user.assemblies.index'); // done
    Route::post('user/assemblies/{assembly}', BuyAssemblyController::class)->name('user.assemblies.store'); // done
});

Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('manufacturers', [ManufacturerController::class, 'index'])->name('manufacturers.index'); // done

    Route::apiResource('components', ComponentController::class)->only('store', 'update');
    Route::apiResource('assemblies', AssemblyController::class)->only('store', 'update');

    Route::post('assemblies/{assembly}/components/{component}', [AssemblyComponentController::class, 'store'])->name('assembly.components.store'); // done
    Route::get('assemblies/{assembly}/components', [AssemblyComponentController::class, 'show'])->name('assembly.components.show'); // done
    Route::delete('assemblies/{assembly}/components/{component}', [AssemblyComponentController::class, 'destroy'])->name('assembly.components.destroy'); // done
});
