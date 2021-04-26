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


// Route::view('/', 'pages/misc.about_us');
// Route::view('/', 'pages/misc.bundle_detail');
// Route::view('/', 'pages/misc.home_page');
// Route::view('/', 'pages/misc.product_detail');
// Route::view('/', 'pages/misc.products_list');

// Route::view('/', 'pages/checkout.add_credit_card');
// Route::view('/', 'pages/checkout.edit_credit_card');
// Route::view('/', 'pages/checkout.cart_info');
// Route::view('/', 'pages/checkout.shipping_payment');

// Route::view('/', 'pages/client.client_profile');

Route::view('/', 'pages/credentials.register');
