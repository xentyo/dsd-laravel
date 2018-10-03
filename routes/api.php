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

Route::group([
    'namespace' => 'API'
], function () {
    Route::group([
        'as' => 'dsd-auth::'
    ], function () {
        Route::post('login', "UserController@login")->middleware('api')->name('login');
        Route::post('register', "UserController@register")->middleware('api')->name('register');
    });
    Route::group([
        'as' => 'dsd-api::',
        'middleware' => 'auth:api'
    ], function () {
        Route::post('logout', "UserController@logout")->middleware('api')->name('logout');
        Route::get('user', 'UserController@show')->middleware('auth:api')->name('user');
        Route::resource('dispenser', 'DispenserController')->only(['index', 'show', 'update', 'store', 'destroy']);
        Route::resource('convertion', 'ConvertionController')->only(['index', 'show', 'update', 'store', 'destroy']);
        Route::resource('item', 'ItemController')->only(['index', 'show', 'update', 'store', 'destroy']);
        Route::resource('kit', 'KitController')->only(['index', 'show', 'update', 'store', 'destroy']);
        Route::resource('movement', 'MovementController')->only(['index', 'show', 'update', 'store', 'destroy']);
        Route::resource('movement-type', 'MovementTypeController')->only(['index', 'show', 'update', 'store', 'destroy']);
        Route::resource('metric', 'MetricController')->only(['index', 'show', 'update', 'store', 'destroy']);
        Route::resource('inventory', 'InventoryController')->only(['index', 'show', 'update', 'store', 'destroy']);
    });
});
