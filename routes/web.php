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
// Home
use Illuminate\Support\Facades\Route;


Route::view('/about_us', 'pages.about_us')->name('about_us');
Route::view('/bundle_detail', 'pages.bundleDetail');
Route::view('/', 'pages.home_page')->name('homepage');
Route::view('/map', 'pages.site_map')->name('map');
