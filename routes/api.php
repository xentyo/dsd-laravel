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
    'namespace' => 'API',
], function () {
    Route::group([
        'as' => 'dsd-auth::',
    ], function () {
        Route::post('login', "UserController@login")->middleware('api')->name('login');
        Route::post('register', "UserController@register")->middleware('api')->name('register');
    });
    Route::group([
        'as' => 'dsd-api::',
        'middleware' => 'auth:api',
    ], function () {
        $apiMethods = ['index', 'show', 'update', 'store', 'destroy'];

        Route::post('logout', "UserController@logout")->middleware('api')->name('logout');
        Route::get('user', 'UserController@show')->middleware('auth:api')->name('user');
        
        Route::resource('dispenser', 'DispenserController')->only($apiMethods);
        Route::post('/dispenser/{id}/item', 'DispenserController@addItems')->name('add-items');
        Route::delete('/dispenser/{id}/item', 'DispenserController@removeItems')->name('remove-items');
        Route::post('/dispenser/{id}/dispense', 'DispenserController@dispense')->name('dispense');
        Route::resource('item', 'ItemController')->only($apiMethods);        
        Route::resource('kit', 'KitController')->only($apiMethods);
        Route::resource('convertion', 'ConvertionController')->only($apiMethods);
        
        Route::resource('movement', 'MovementController')->only($apiMethods);
        Route::resource('movement-type', 'MovementTypeController')->only($apiMethods);
        
        Route::resource('metric', 'MetricController')->only($apiMethods);

        Route::resource('inventory', 'InventoryController')->only($apiMethods);
    });
});
