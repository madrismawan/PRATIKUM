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
    return view('user.home');
});

Auth::routes(['verify' => true, 'guest']);
Route::get('/chart','AdminController@chart');
Route::get('/home', 'UserController@index')->middleware(['auth','verified'])->name('home');
Route::post('/marknotifAdmin', 'AdminController@marknotif');
//Route Admin
Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminLoginController@showLoginform')->middleware('guest')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->middleware('guest')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard')->middleware('authAdmin:admin');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/order/new', 'AdminController@orderNew');
    Route::get('/order/process', 'AdminController@orderProces');
    Route::get('/order/success', 'AdminController@orderSuccess');
    Route::get('/order/cek/{id}', 'AdminController@orderDetail');
    Route::get('/order/cancel', 'AdminController@orderCancel');
    Route::get('/marknotifadmin', 'AdminController@markReadAdmin');
});

Route::patch('/order/update/{id}', 'AdminController@orderUpdate');

Route::group(['middleware'=>['authAdmin:admin']],function(){
//Product
Route::resource('products','ProductController');
Route::get('/addImage/{id}', 'ProductController@upload');
Route::post('/addImage/{id}', 'ProductController@upload_image');
Route::get('/products/delete/{id}', 'ProductController@soft_delete');
Route::get('/products-trash', 'ProductController@trash');
Route::get('/products/restore/{id}', 'ProductController@restore');
Route::get('/products-restore-all', 'ProductController@restore_all');
Route::get('/products/destroy/{id}', 'ProductController@delete');
Route::get('/products-delete-all', 'ProductController@delete_all');
Route::resource('product_images','ProductImageController');
Route::get('/category_detail/delete/{id}', 'ProductController@soft_delete_category');
Route::get('/category_detail/create/{id}', 'ProductController@add_category');
Route::post('/category_detail/store', 'ProductController@store_category');
Route::resource('response', 'ResponseController');

//Courier
Route::resource('couriers', 'CourierController');
Route::get('/couriers/delete/{id}', 'CourierController@soft_delete');
Route::get('/couriers-trash', 'CourierController@trash');
Route::get('/couriers/restore/{id}', 'CourierController@restore');
Route::get('/couriers-restore-all', 'CourierController@restore_all');
Route::get('/couriers/destroy/{id}', 'CourierController@delete');
Route::get('/couriers-delete-all', 'CourierController@delete_all');

//Product_Categories
Route::resource('categories', 'CategoryController');
Route::get('/categories/delete/{id}', 'CategoryController@soft_delete');
Route::get('/categories-trash', 'CategoryController@trash');
Route::get('/categories/restore/{id}', 'CategoryController@restore');
Route::get('/categories-restore-all', 'CategoryController@restore_all');
Route::get('/categories/destroy/{id}', 'CategoryController@delete');
Route::get('/categories-delete-all', 'CategoryController@delete_all');

//Discount
Route::resource('discounts', 'DiscountController');
Route::get('/discounts/delete/{id}', 'DiscountController@soft_delete');
Route::get('/discounts/add/{id}', 'DiscountController@add_discount');
});

Route::group(['middleware'=>['auth','verified']], function(){
//User
Route::resource('users', 'UserController');
Route::resource('carts', 'CartController');
Route::post('/carts/add', 'CartController@store');
Route::get('/carts/delete/{id}', 'CartController@delete');
Route::post('/carts/update', 'CartController@update');
Route::patch('/carts/checkout/{id}', 'CartController@checkout_status');
Route::get('/carts/checkout/{id}', 'CartController@checkout_status');
Route::get('/userscheckout', 'UserController@checkout');
Route::resource('transactions', 'TransactionController');
Route::get('/province/{id}/cities', 'TransactionController@getCities');
Route::get('/destination/cost', 'TransactionController@getOngkir');
Route::post('/carts/update', 'CartController@update');
Route::post('/checkout/cancel/{id}', 'CartController@cancel_checkout');
Route::get('/users/{id}/invoice', 'UserController@invoice');
Route::get('/users/invoice/{id}', 'UserController@getInvoice');
Route::get('/users/search/category', 'UserController@search_category');
Route::patch('/uploadPOP/{id}', 'UserController@uploadPOP');
Route::get('/users/search/name','UserController@search');
Route::patch('/transaction/success/{id}', 'UserController@confirmation');
Route::resource('reviews', 'ReviewController');
Route::patch('/transactions/cancel/{id}', 'UserController@cancel_transaction');
Route::post('/users/checkout/{id}', 'TransactionController@checkout_no_cart');
Route::get('/marknotif', 'UserController@marknotif');
Route::get('/destination/service', 'TransactionController@getService');
});

