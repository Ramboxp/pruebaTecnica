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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//Color
Route::group(['prefix' => '/'], function () {
    Route::resource('color', 'API\ColorController');
    Route::resource('size', 'API\SizeController');
    Route::resource('race', 'API\RaceController');
    Route::resource('dog', 'API\DogController');
});
