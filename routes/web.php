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

Auth::routes();

Route::get('/', function () {
    return redirect('/category');
});

Route::post('/category', 'CategoryController@create')->name('cateogry.create');
Route::patch('/category/{category}', 'CategoryController@update')->name('cateogry.update');
Route::delete('/category/{category}', 'CategoryController@destroy')->name('cateogry.destroy');
Route::get('/category', 'CategoryController@index')->name('cateogry.index');

Route::post('/product', 'ProductController@create')->name('product.create');
Route::patch('/product/{product}', 'ProductController@update')->name('product.update');
Route::delete('/product/{product}', 'ProductController@destroy')->name('product.destroy');
Route::get('/product', 'ProductController@index')->name('product.index');

// Route::get('/home', 'HomeController@index')->name('home');
