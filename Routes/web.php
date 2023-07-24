<?php

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

use Illuminate\Support\Facades\Route;
use Modules\RetailObjectsRestourant\Http\Controllers\Admin\DeliveryZones\DeliveryZoneController;
use Modules\RetailObjectsRestourant\Http\Controllers\Admin\RetailObjectsRestaurantSettingsController;
use Modules\RetailObjectsRestourant\Http\Controllers\RetailObjectsRestourantController;

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], static function () {

    /* Restaurants */
    Route::group(['prefix' => 'retail-objects-restaurants'], static function () {
        /* Delivery Zones */
        Route::group(['prefix' => 'delivery-zones'], static function () {
            Route::get('/', [DeliveryZoneController::class, 'index'])->name('admin.retail-objects-restaurants.delivery-zones.index');
        });

        /* Settings */
        Route::group(['prefix' => 'settings'], static function () {
            Route::get('/', [RetailObjectsRestaurantSettingsController::class, 'index'])->name('admin.retail-objects-restaurants.settings.index');
            Route::post('update', [RetailObjectsRestaurantSettingsController::class, 'update'])->name('admin.retail-objects-restaurants.settings.update');
        });

        Route::get('/', [RetailObjectsRestourantController::class, 'index'])->name('admin.retail-objects-restaurants.index');
        Route::get('/create', [RetailObjectsRestourantController::class, 'create'])->name('admin.retail-objects-restaurants.create');
        Route::post('/store', [RetailObjectsRestourantController::class, 'store'])->name('admin.retail-objects-restaurants.store');

        Route::group(['prefix' => 'multiple'], static function () {
            Route::get('active/{active}', [RetailObjectsRestourantController::class, 'activeMultiple'])->name('admin.retail-objects-restaurants.active-multiple');
            Route::get('delete', [RetailObjectsRestourantController::class, 'deleteMultiple'])->name('admin.retail-objects-restaurants.delete-multiple');
        });

        Route::group(['prefix' => '{id}'], static function () {
            Route::get('edit', [RetailObjectsRestourantController::class, 'edit'])->name('admin.retail-objects-restaurants.edit');
            Route::post('update', [RetailObjectsRestourantController::class, 'update'])->name('admin.retail-objects-restaurants.update');
            Route::get('delete', [RetailObjectsRestourantController::class, 'delete'])->name('admin.retail-objects-restaurants.delete');
            Route::get('show', [RetailObjectsRestourantController::class, 'show'])->name('admin.retail-objects-restaurants.show');
            Route::get('/active/{active}', [RetailObjectsRestourantController::class, 'active'])->name('admin.retail-objects-restaurants.changeStatus');
            Route::get('position/up', [RetailObjectsRestourantController::class, 'positionUp'])->name('admin.retail-objects-restaurants.position-up');
            Route::get('position/down', [RetailObjectsRestourantController::class, 'positionDown'])->name('admin.retail-objects-restaurants.position-down');
            Route::get('image/delete', [RetailObjectsRestourantController::class, 'deleteImage'])->name('admin.retail-objects-restaurants.delete-image');

            /* Restaurant Delivery Zone */
            Route::group(['prefix' => 'delivery-zone'], static function () {
                Route::get('/', [RetailObjectsRestourantController::class, 'deliveryZone'])->name('admin.retail-objects-restaurants.delivery-zone.index');
            });

            /* Restaurant Working Time */
            Route::group(['prefix' => 'working-time'], static function () {
                Route::get('/', [RetailObjectsRestourantController::class, 'workingTime'])->name('admin.retail-objects-restaurants.working-time.index');
            });
        });
    });
});
