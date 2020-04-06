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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/admin',function(){
        return view('admin.dashboard');
    });
    Route::get('/users-list','Admin\DashboardController@registred');
    Route::get('/user-edit/{id}','Admin\DashboardController@registredEdit');
    Route::put('/user-update/{id}','Admin\DashboardController@registredUpdate');
    Route::delete('/user-delete/{id}','Admin\DashboardController@registredDelete');
});
