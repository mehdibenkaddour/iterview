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
Route::group(['prefix' => 'v1/user'], function (){ 
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('signin', 'API\AuthController@login');
        Route::post('signup', 'API\AuthController@signup');
    });
    /*Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'API\AuthController@logout');
        Route::get('getuser', 'API\AuthController@getUser');
    });*/
}); 
Route::group(['prefix' => 'v1/topics'], function (){ 
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('', 'API\TopicController@index');
        Route::get('/{id}', 'API\TopicController@show');
        Route::get('/{id}/sections','API\SectionController@show');
    });
});

Route::group(['prefix' => 'v1/sections'], function (){ 
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('', 'API\SectionController@index');
        Route::get('/{id}/questions', 'API\QuestionController@show');
        Route::get('/{id}/answers', 'API\AnswerController@answers');
    });
});


Route::group(['prefix' => 'v1/questions'], function (){ 
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/{id}/answers', 'API\AnswerController@show');
    });
});