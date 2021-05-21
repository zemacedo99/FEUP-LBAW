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

Route::get('/item/{id}', 'ItemController@show');
Route::get('/items', 'ItemController@list')->name('items');
Route::get('/suppliers', 'SupplierController@list')->name('suppliers');

Route::view('/about_us', 'pages.misc.about_us')->name('about_us');
Route::view('/bundle_detail', 'pages.misc.bundleDetail');
Route::get('/', 'ItemController@homePage')->name('homepage');
Route::view('/map', 'pages.site_map')->name('map');

Route::get('/dashboard', 'UserController@admin_dashboard')->name('dashboard');
Route::get('/dashboard_products', 'ItemController@admin_list')->name('admin_products');
Route::get('/dashboard_clients', 'UserController@admin_index')->name('admin_users');
Route::get('/dashboard_requests', 'SupplierController@requests')->name('admin_requests');
Route::get('/users/{id}', 'UserController@getProfile');

Route::get('/supplier/{id}/createBundle', 'ItemController@create')->name('create_bundle');
Route::get('/supplier/{id}/createProduct', 'ProductController@create')->name('create_product');
Route::get('/supplier/{id}/createCoupon', 'CouponController@create')->name('create_coupon');

// Coupon

Route::get('/coupon/{couponCode}', 'CouponController@edit');

Route::get('/api/coupon', 'CouponController@index');
Route::post('/api/coupon', 'CouponController@store');
Route::get('/api/coupon/{couponCode}', 'CouponController@show');
Route::put('/api/coupon/{couponCode}', 'CouponController@update');
Route::delete('/api/coupon/{couponCode}', 'CouponController@destroy');

// review
Route::get('/api/review', 'ReviewController@index');
Route::post('/api/review', 'ReviewController@create');
Route::delete('/api/review', 'ReviewController@delete');
Route::put('/api/review', 'ReviewController@update');



// Product
Route::get('/product/{id}', 'ProductController@edit');

Route::post('/api/bundle', 'ItemController@store');
Route::get('/api/product', 'ProductController@index');
Route::post('/api/product', 'ProductController@store');
Route::get('/api/product/{id}', 'ProductController@show');
Route::put('/api/product/{id}', 'ProductController@update');
Route::delete('/api/product/{id}', 'ProductController@destroy');

Route::get('/api/client/{id}/history', 'PurchaseController@index');
Route::get('/api/client/{id}/periodic', 'PurchaseController@index');//reevaluate
Route::post('/client/{id}/checkoutInfo', 'PurchaseController@create');

// Credit Card
Route::post('/api/creditcard', 'CreditCardController@create');
Route::put('/api/creditcard', 'CreditCardController@update');
Route::delete('/api/creditcard', 'CreditCardController@destroy');

// Ship Details
Route::post('/api/shipdetails', 'ShipDetailController@create');

//shoppers
//maybe get supplier profiles
Route::get('/api/supplier', 'SupplierController@index');
Route::get('/supplier', 'SupplierController@index');
Route::get('/supplier/{id}', 'SupplierController@show')->name('supplierProfile');
Route::get('/supplier/{id}/allproducts', 'SupplierController@allProducts')->name('supplier_all_products');
Route::get('/supplier/{id}/bundles&coupons', 'SupplierController@bundles_and_coupons')->name('supplier_bundles_and_coupons');
Route::post('/supplier', 'SupplierController@requestHandling');

// Client
Route::get('/api/client', 'ClientController@index');
//Route::post('/api/client', 'ClientController@store');
Route::put('/api/client/{id}', 'ClientController@update');
Route::delete('/api/client/{id}', 'ClientController@destroy');




// Item

Route::get('/api/item', 'ItemController@index');
Route::post('/api/item', 'ClientController@store');
Route::get('/api/item/{id}', 'ItemController@view');
Route::put('/api/item/{id}', 'ItemController@update');
Route::delete('/api/item/{id}', 'ItemController@deactivate');

// Tag
Route::get('/api/tag', 'TagController@index');
Route::post('/api/tag', 'TagController@create');
Route::get('/api/tag/{tagName}', 'TagController@getObject');
Route::delete('/api/tag/{tagName}','TagController@destroy');

// Checkout

Route::get('/client/{id}/checkoutInfo', 'ItemController@checkout')->name('checkout');
Route::get('/client/{id}/checkoutPayment', 'ItemController@payment')->name('payment');
Route::post('/api/checkout', 'ItemController@save_checkout');
Route::post('/api/payment', 'ItemController@do_payment');



// // Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');


// ANDRE - WORKING ON BELOW THIS

Route::get('client/{client:id}/profile', 'ClientController@show');

/*
* API Calls
*/

Route::prefix('api/')->group(function(){
    Route::prefix('client/')->group(function(){
        Route::get('{client:id}','ClientController@get_info');
    });

    Route::prefix('supplier/')->group(function(){
        Route::get('{supplier:id}','SupplierController@get_info');
        Route::put('{supplier:id}','SupplierController@update');
    });
});
