<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['web','auth'])->group(function(){
    Route::get('company','CompanyController@show')->name('company.show');
    Route::put('company/{company}','CompanyController@update')->name('company.update');
    Route::get('roles','RoleController@layout')->name('role.layout');
    Route::apiResource('/api/v1/roles','RoleController');
    Route::get('users','UserController@layout')->name('users.layout');
    Route::apiResource('/api/v1/users','UserController');
});
