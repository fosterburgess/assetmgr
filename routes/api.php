<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\CompanyContactsController;
use App\Http\Controllers\Api\company_contactController;
use App\Http\Controllers\Api\ContactCompaniesController;
use App\Http\Controllers\Api\ContactManufacturersController;
use App\Http\Controllers\Api\ManufacturerContactsController;
use App\Http\Controllers\Api\contact_manufacturerController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('categories', CategoryController::class);

        Route::apiResource('companies', CompanyController::class);

        // Company Contacts
        Route::get('/companies/{company}/contacts', [
            CompanyContactsController::class,
            'index',
        ])->name('companies.contacts.index');
        Route::post('/companies/{company}/contacts/{contact}', [
            CompanyContactsController::class,
            'store',
        ])->name('companies.contacts.store');
        Route::delete('/companies/{company}/contacts/{contact}', [
            CompanyContactsController::class,
            'destroy',
        ])->name('companies.contacts.destroy');

        Route::apiResource('contacts', ContactController::class);

        // Contact Companies
        Route::get('/contacts/{contact}/companies', [
            ContactCompaniesController::class,
            'index',
        ])->name('contacts.companies.index');
        Route::post('/contacts/{contact}/companies/{company}', [
            ContactCompaniesController::class,
            'store',
        ])->name('contacts.companies.store');
        Route::delete('/contacts/{contact}/companies/{company}', [
            ContactCompaniesController::class,
            'destroy',
        ])->name('contacts.companies.destroy');

        // Contact Manufacturers
        Route::get('/contacts/{contact}/manufacturers', [
            ContactManufacturersController::class,
            'index',
        ])->name('contacts.manufacturers.index');
        Route::post('/contacts/{contact}/manufacturers/{manufacturer}', [
            ContactManufacturersController::class,
            'store',
        ])->name('contacts.manufacturers.store');
        Route::delete('/contacts/{contact}/manufacturers/{manufacturer}', [
            ContactManufacturersController::class,
            'destroy',
        ])->name('contacts.manufacturers.destroy');

        Route::apiResource('manufacturers', ManufacturerController::class);

        // Manufacturer Contacts
        Route::get('/manufacturers/{manufacturer}/contacts', [
            ManufacturerContactsController::class,
            'index',
        ])->name('manufacturers.contacts.index');
        Route::post('/manufacturers/{manufacturer}/contacts/{contact}', [
            ManufacturerContactsController::class,
            'store',
        ])->name('manufacturers.contacts.store');
        Route::delete('/manufacturers/{manufacturer}/contacts/{contact}', [
            ManufacturerContactsController::class,
            'destroy',
        ])->name('manufacturers.contacts.destroy');
    });
