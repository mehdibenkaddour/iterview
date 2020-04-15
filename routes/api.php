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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group([ 'prefix' => 'v1/user'], function (){ 
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('signin', 'API\AuthController@login');
        Route::post('signup', 'API\AuthController@signup');
    });
    /*Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'API\AuthController@logout');
        Route::get('getuser', 'API\AuthController@getUser');
    });*/
}); 
Route::group([ 'prefix' => 'v1/topics'], function (){ 
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('', 'API\TopicController@index');
        Route::post('/{id}', 'API\TopicController@show');
    });
});
