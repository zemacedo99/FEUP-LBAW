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
use App\Http\Controllers\UploadController;


Route::get('image/{filename}', 'ItemController@storage_link');
Route::view('upload', 'upload');
Route::post('upload',[UploadController::class,'index']);

Route::get('/client/{id}', 'ClientController@show');
Route::get('/item/{id}', 'ItemController@show');
Route::get('/items', 'ItemController@list')->name('items');
Route::get('/stores', 'SupplierController@list')->name('stores');

Route::view('/about_us', 'pages.misc.about_us')->name('about_us');
Route::view('/bundle_detail', 'pages.misc.bundleDetail');
Route::view('/', 'pages.misc.home_page')->name('homepage');
Route::view('/map', 'pages.site_map')->name('map');

Route::view('/dashboard', 'pages.admin.dashboard')->name('dashboard');
Route::view('/dashboard_products', 'pages.admin.products')->name('admin_products');
Route::view('/dashboard_clients', 'pages.admin.users')->name('admin_users');
Route::view('/dashboard_requests', 'pages.admin.requests')->name('admin_requests');

Route::get('/supplier/{id}/createBundle', 'ItemController@create');
Route::get('/supplier/{id}/createProduct', 'ProductController@show');
Route::get('/supplier/{id}/createCoupon', 'CouponController@create');

// Coupon
Route::get('/api/coupon', 'CouponController@index');
Route::post('/api/coupon', 'CouponController@store');
Route::get('/api/coupon/{couponCode}', 'CouponController@show');
Route::put('/api/coupon/{couponCode}', 'CouponController@update');
Route::delete('/api/coupon/{couponCode}', 'CouponController@destroy');

Route::get('/api/review', 'ReviewController@index');
Route::post('/api/review', 'ReviewController@create');
Route::delete('/api/review', 'ReviewController@delete');
//falta put

Route::get('/api/client/{id}/history', 'PurchaseController@index');
Route::get('/api/client/{id}/periodic', 'PurchaseController@index');//reevaluate
Route::post('/client/{id}/checkoutInfo', 'PurchaseController@create');

//ship details
Route::get('/client/{id}/checkoutPayment', 'ShipDetailController@index');
Route::post('/client/{id}/checkoutPayment', 'ShipDetailController@create');

//shoppers
//maybe get supplier profiles
Route::get('/api/supplier', 'SupplierController@index');
Route::get('/supplier', 'SupplierController@index');
Route::get('/supplier/{id}', 'SupplierController@show');

// Client
Route::get('/api/client', 'ClientController@index');
//Route::post('/api/client', 'ClientController@store');
Route::get('/api/client/{id}', 'ClientController@get_info');
Route::put('/api/client/{id}', 'ClientController@update');
Route::delete('/api/client/{id}', 'ClientController@destroy');



// Item

Route::get('/api/item', 'ItemController@index');
Route::post('/api/item', 'ClientController@store');
Route::get('/api/item/{id}', 'ItemController@view');
Route::put('/api/item/{id}', 'ItemController@update');
Route::delete('/api/item/{id}', 'ItemController@destroy');

// Route::get('/', 'Auth\LoginController@home');

// // Cards
// Route::get('cards', 'CardController@list');
// Route::get('cards/{id}', 'CardController@show');

// // API
// Route::put('api/cards', 'CardController@create');
// Route::delete('api/cards/{card_id}', 'CardController@delete');
// Route::put('api/cards/{card_id}/', 'ItemController@create');
// Route::post('api/item/{id}', 'ItemController@update');
// Route::delete('api/item/{id}', 'ItemController@delete');

// // Authentication
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');
// Route::get('logout', 'Auth\LoginController@logout')->name('logout');
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');
