<?php

use App\Http\Controllers\Api\V1\CompanyApiController;
use App\Http\Controllers\Api\V1\ContactApiController;
use App\Http\Controllers\Api\V1\IndustryApiController;
use App\Http\Controllers\Api\V1\LookupIndustriesApiController;
use App\Http\Controllers\Api\V1\LookupTeamUsersApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('industries', IndustryApiController::class);
    Route::resource('companies', CompanyApiController::class);
    Route::resource('contacts', ContactApiController::class);

    Route::prefix('lookups')->name('lookup.')->group(function () {
        Route::get('team-users', LookupTeamUsersApiController::class)->name('team-users');
        Route::get('team-industries', LookupIndustriesApiController::class)->name('team-industries');
    });
});
