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

Route::POST('/Posts','PostController@Create')->name('CreatePost');
Route::PATCH('/Posts/{post}','PostController@Update')->name('UpdatePost');
Route::DELETE('/Posts/{post}','PostController@Destory')->name('DestoryPost');


Route::POST('/Users','UserController@Create')->name('CreateUser');

Route::Post('/Private/{post}','PrivateController@store')->name('SetPrivate');
Route::Post('/CancelPrivate/{post}','CancelPrivateController@store')->name('CancelPrivate');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
