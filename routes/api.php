<?php

use Illuminate\Http\Request;

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

Route::group(['as' => 'dsd-api::'], function () {
    Route::resource('dipenser', 'DispenserController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('convertion', 'ConvertionController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('item', 'ItemController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('kit', 'KitController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('movement', 'MovementController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('movement-type', 'MovementTypeController')->only(['index', 'update', 'store', 'destroy']);
    Route::resource('metric', 'MetricController')->only(['index', 'update', 'store', 'destroy']);
});