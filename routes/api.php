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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', 'HomeController@index' );
Route::post('/v1/plan/new', 'PlanController@store');
Route::post('/v1/plan/show', 'PlanController@show');
Route::post('/v1/plan/update', 'PlanController@update');

Route::post('/v1/prefs/get', 'PreferencesController@get');
Route::post('/v1/prefs/set', 'PreferencesController@set');

