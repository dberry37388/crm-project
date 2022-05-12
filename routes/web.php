<?php

use App\Http\Controllers\Frontend\Companies\ListCompaniesController;
use App\Http\Controllers\Frontend\Companies\ShowCompanyController;
use App\Http\Controllers\Frontend\Contacts\ListContactsController;
use App\Http\Controllers\Frontend\Contacts\ShowContactController;
use App\Http\Controllers\Frontend\Deals\ListDealsController;
use App\Http\Controllers\Frontend\Deals\ShowDealController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', AuthenticatedSessionController::class . '@create');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'teams'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('companies')->name('companies.')->group(function () {
        Route::get('/', ListCompaniesController::class)->name('list');
        Route::get('{company}', ShowCompanyController::class)->name('show');
    });

    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', ListContactsController::class)->name('list');
        Route::get('{contact}', ShowContactController::class)->name('show');
    });

    Route::prefix('deals')->name('deals.')->group(function () {
        Route::get('/', ListDealsController::class)->name('list');
        Route::get('{deal}', ShowDealController::class)->name('show');
    });
});
