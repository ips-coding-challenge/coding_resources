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

//Auth::routes();

Route::get('/', 'Web\HomeController@index');
Route::get('/sitemap', 'Web\SitemapController@index');

Route::get('/search', 'Web\HomeController@search');
Route::get('/{type}/{slug}', 'Web\HomeController@show')->where(['type' => 'conference|tuto']);
Route::get('/proposition', 'Web\HomeController@create');
// Route::get('/about', 'Web\HomeController@about');
Route::get('/contact', 'Web\PrivateMessageController@contact');
Route::post('/contact', 'Web\PrivateMessageController@store')->name('contact.store');

Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

//Route::get('/home', 'HomeController@index')->name('home');

