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

Route::get('/',  function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/admin', function(){
        return view('admin.index');
    })->name('admin');
    Route::get('/users','Admin\UserController@index')->name('users');
    Route::get('/users/edit/{id}','Admin\UserController@edit')->name('users.edit');
    Route::put('/users/{id}','Admin\UserController@update')->name('users.update');
    Route::delete('/users/delete/{id}','Admin\UserController@delete')->name('users.delete');
});
