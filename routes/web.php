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

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/test', function () {
//    return view('test');
//});

//Auth::routes();

Route::group(['namespace' => 'Admin' , 'prefix' => 'admin' ,],function (){
    Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'LoginController@login');

    Route::get('register', 'RegisterController@showRegistrationForm')->name('admin.register');
    Route::post('register', 'RegisterController@register');

    Route::post('logout', 'LoginController@logout')->name('admin.logout');
    Route::group(['name'=>'admin.','middleware'=> ['auth.admin:admin'] ],function (){
        Route::get('/','HomeController@index');
    });

});

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Head' , 'prefix' => 'head' ,],function (){
    Route::post('/headSchool-list','HeadSchoolController@school_list')->name('headSchool-list');
});

