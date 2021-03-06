<?php

use App\Http\Controllers\Api\V1\CompanyActivitiesApiController;
use App\Http\Controllers\Api\V1\CompanyApiController;
use App\Http\Controllers\Api\V1\CompanyContactsApiController;
use App\Http\Controllers\Api\V1\CompanyDealsApiController;
use App\Http\Controllers\Api\V1\CompanyNotesApiController;
use App\Http\Controllers\Api\V1\CompanyTasksApiController;
use App\Http\Controllers\Api\V1\ContactActivitiesApiController;
use App\Http\Controllers\Api\V1\ContactApiController;
use App\Http\Controllers\Api\V1\ContactCompaniesApiController;
use App\Http\Controllers\Api\V1\ContactDealsApiController;
use App\Http\Controllers\Api\V1\ContactNotesApiController;
use App\Http\Controllers\Api\V1\ContactTasksApiController;
use App\Http\Controllers\Api\V1\DealActivitiesApiController;
use App\Http\Controllers\Api\V1\DealApiController;
use App\Http\Controllers\Api\V1\DealCompaniesApiController;
use App\Http\Controllers\Api\V1\DealContactsApiController;
use App\Http\Controllers\Api\V1\DealNotesApiController;
use App\Http\Controllers\Api\V1\DealTasksApiController;
use App\Http\Controllers\Api\V1\IndustryApiController;
use App\Http\Controllers\Api\V1\LookupIndustriesApiController;
use App\Http\Controllers\Api\V1\LookupTeamDealsApiController;
use App\Http\Controllers\Api\V1\LookupTeamUsersApiController;
use App\Http\Controllers\Api\V1\NoteApiController;
use App\Http\Controllers\Api\V1\TaskApiController;
use App\Http\Controllers\Api\V1\TeamCompaniesApiController;
use App\Http\Controllers\Api\V1\TeamContactsApiController;
use App\Http\Controllers\Api\V1\TeamDealsApiController;
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
    Route::resource('notes', NoteApiController::class);
    Route::resource('tasks', TaskApiController::class);
    Route::resource('deals', DealApiController::class);

    Route::prefix('companies/{company}')->name('company.')->group(function () {

        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', CompanyContactsApiController::class . '@index')->name('list');
            Route::post('/', CompanyContactsApiController::class . '@store')->name('store');
            Route::delete('{contact}', CompanyContactsApiController::class . '@detach')->name('detach');
            Route::post('{contact?}', CompanyContactsApiController::class . '@attach')->name('attach');
        });

        Route::prefix('deals')->name('deals.')->group(function () {
            Route::get('/', CompanyDealsApiController::class . '@index')->name('list');
            Route::post('/', CompanyDealsApiController::class . '@store')->name('store');
            Route::delete('{deal}', CompanyDealsApiController::class . '@detach')->name('detach');
            Route::post('{deal?}', CompanyDealsApiController::class . '@attach')->name('attach');
        });

        Route::prefix('notes')->group(function () {
            Route::get('/', CompanyNotesApiController::class . '@index')->name('list-notes');
            Route::post('/', CompanyNotesApiController::class . '@store')->name('store-note');
        });

        Route::prefix('tasks')->name('tasks.')->group(function () {
            Route::get('/', CompanyTasksApiController::class . '@index')->name('list');
            Route::post('/', CompanyTasksApiController::class . '@store')->name('store');
        });

        Route::get('activities', CompanyActivitiesApiController::class . '@index')->name('activities.list');
    });

    Route::prefix('contacts/{contact}')->name('contact.')->group(function () {
        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/', ContactCompaniesApiController::class . '@index')->name('list');
            Route::post('/', ContactCompaniesApiController::class . '@store')->name('store');
            Route::delete('{company}', ContactCompaniesApiController::class . '@detach')->name('detach');
            Route::post('{company?}', ContactCompaniesApiController::class . '@attach')->name('attach');
        });

        Route::prefix('deals')->name('deals.')->group(function () {
            Route::get('/', ContactDealsApiController::class . '@index')->name('list');
            Route::post('/', ContactDealsApiController::class . '@store')->name('store');
            Route::delete('{deal}', ContactDealsApiController::class . '@detach')->name('detach');
            Route::post('{deal?}', ContactDealsApiController::class . '@attach')->name('attach');
        });

        Route::prefix('notes')->group(function () {
            Route::get('/', ContactNotesApiController::class . '@index')->name('list-notes');
            Route::post('/', ContactNotesApiController::class . '@store')->name('store-note');
        });

        Route::prefix('tasks')->name('tasks.')->group(function () {
            Route::get('/', ContactTasksApiController::class . '@index')->name('list');
            Route::post('/', ContactTasksApiController::class . '@store')->name('store');
        });

        Route::get('activities', ContactActivitiesApiController::class . '@index')->name('activities.list');
    });

    /* section Deal API */
    Route::prefix('deals/{deal}')->name('deal.')->group(function () {
        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/', DealCompaniesApiController::class . '@index')->name('list');
            Route::post('/', DealCompaniesApiController::class . '@store')->name('store');
        });

        Route::prefix('contacts')->name('contacts.')->group(function () {
            Route::get('/', DealContactsApiController::class . '@index')->name('list');
            Route::post('/', DealContactsApiController::class . '@store')->name('store');
            Route::delete('{contact}', DealContactsApiController::class . '@detach')->name('detach');
            Route::post('{contact?}', DealContactsApiController::class . '@attach')->name('attach');
        });

        Route::prefix('companies')->name('companies.')->group(function () {
            Route::get('/', DealCompaniesApiController::class . '@index')->name('list');
            Route::post('/', DealCompaniesApiController::class . '@store')->name('store');
            Route::delete('{company}', DealCompaniesApiController::class . '@detach')->name('detach');
            Route::post('{company?}', DealCompaniesApiController::class . '@attach')->name('attach');
        });

        Route::prefix('notes')->group(function () {
            Route::get('/', DealNotesApiController::class . '@index')->name('list-notes');
            Route::post('/', DealNotesApiController::class . '@store')->name('store-note');
        });

        Route::prefix('tasks')->name('tasks.')->group(function () {
            Route::get('/', DealTasksApiController::class . '@index')->name('list');
            Route::post('/', DealTasksApiController::class . '@store')->name('store');
        });

        Route::get('activities', DealActivitiesApiController::class . '@index')->name('activities.list');
    });

    /* section Lookups */
    Route::prefix('lookups')->name('lookup.')->group(function () {
        Route::get('team-users', LookupTeamUsersApiController::class)->name('team-users');
        Route::get('team-industries', LookupIndustriesApiController::class)->name('team-industries');
        Route::get('team-deals', LookupTeamDealsApiController::class)->name('team-industries');
    });

    /* section Current Team */
    Route::prefix('currentTeam')->name('currentTeam.')->group(function () {
        Route::get('companies', TeamCompaniesApiController::class . '@index')->name('list-companies');
        Route::get('contacts', TeamContactsApiController::class . '@index')->name('list-contacts');
        Route::get('contacts', TeamDealsApiController::class . '@index')->name('list-deals');
    });
});
