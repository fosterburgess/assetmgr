<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\company_contactController;
use App\Http\Controllers\Api\LocationContactsController;
use App\Http\Controllers\Api\ContactLocationsController;
use App\Http\Controllers\Api\LocationAllEquipmentController;
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

        Route::apiResource('companies', LocationController::class);

        // Location All Equipment
        Route::get('/locations/{location}/all-equipment', [
            LocationAllEquipmentController::class,
            'index',
        ])->name('locations.all-equipment.index');
        Route::post('/locations/{location}/all-equipment', [
            LocationAllEquipmentController::class,
            'store',
        ])->name('locations.all-equipment.store');

        // Location Contacts
        Route::get('/locations/{location}/contacts', [
            LocationContactsController::class,
            'index',
        ])->name('locations.contacts.index');
        Route::post('/locations/{location}/contacts/{contact}', [
            LocationContactsController::class,
            'store',
        ])->name('locations.contacts.store');
        Route::delete('/locations/{location}/contacts/{contact}', [
            LocationContactsController::class,
            'destroy',
        ])->name('locations.contacts.destroy');

        Route::apiResource('contacts', ContactController::class);

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

        // Contact Locations
        Route::get('/contacts/{contact}/locations', [
            ContactLocationsController::class,
            'index',
        ])->name('contacts.locations.index');
        Route::post('/contacts/{contact}/locations/{location}', [
            ContactLocationsController::class,
            'store',
        ])->name('contacts.locations.store');
        Route::delete('/contacts/{contact}/locations/{location}', [
            ContactLocationsController::class,
            'destroy',
        ])->name('contacts.locations.destroy');

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

        Route::apiResource('all-equipment', EquipmentController::class);
    });
