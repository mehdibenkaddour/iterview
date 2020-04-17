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
    
    // This route is for ajax
    Route::get('/ajax/users', 'Admin\UserController@users')->name('ajax.users');
    
    Route::resource('users','Admin\UserController',['names' => [
        'index' => 'users',
        'update' => 'users.update',
        'destroy' => 'users.delete'
        ],'only'=> [
            'index','update','destroy'
        ]
    ])->parameters(
        ['users' => 'id'
    ]);
    Route::resource('topics','Admin\TopicController')->parameters(
        ['topics' => 'id']
    );
    Route::resource('sections','Admin\SectionController')->parameters(
        ['sections' => 'id']
    );
});
