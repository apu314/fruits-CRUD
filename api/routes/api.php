<?php

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

Route::get('fruits', 'FruitController@index');
Route::post('fruit', 'FruitController@store');
Route::get('fruit/{id}', 'FruitController@show');
Route::put('fruit/{id}', 'FruitController@update');
Route::delete('fruit/{id}', 'FruitController@destroy');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
