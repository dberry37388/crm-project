<?php

use App\Http\Controllers\Api\V1\Industry\GetIndustriesApiController;
use App\Http\Controllers\Api\V1\Industry\ShowIndustryApiController;
use App\Http\Controllers\Api\V1\Industry\StoreIndustryApiController;
use App\Http\Controllers\Api\V1\Industry\UpdateIndustryApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('industries')->name('industries.')->group(function () {
    Route::get('/', GetIndustriesApiController::class)->name('index');
    Route::post('/', StoreIndustryApiController::class)->name('store');
    Route::get('{industry}', ShowIndustryApiController::class)->name('show');
    Route::put('{industry}', UpdateIndustryApiController::class)->name('update');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
