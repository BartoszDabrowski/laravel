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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('loaning', 'MoneyController@loan');
Route::post('transfering', 'MoneyController@transfer');
Route::get('/logout', 'HomeController@logout');

Route::get('balance','DataController@balance');
Route::get('history','DataController@history');
