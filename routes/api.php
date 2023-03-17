<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Login
Route::post('login', 'Api\UserController@login');
// Registration
Route::post('customer/register', 'Api\UserController@register');
// Painter Registration
Route::post('painter/register', 'Api\UserController@painterRegister');
// Google Login
Route::post('customer/google/login', 'Api\UserController@googleLogin');
// aadhar document add
Route::post('painter/identityDocument/upload', 'Api\UserController@CreateAadhar');
// image add
Route::post('image/upload', 'Api\UserController@CreateImage');
//user profile details
Route::get('user/profile/{id}', 'Api\UserController@myprofile');
//edit profile
Route::post('update/profile/{id}', 'Api\UserController@updateProfile');
//change password
Route::post('change/password', 'Api\UserController@changePassword');
//category list
Route::get('category', 'Api\CategoryController@index');
//category details id wise
Route::get('category/show/{id}', 'Api\CategoryController@show');
//product details by category Id
Route::get('category/{categoryId}/products', 'Api\CategoryController@productList');

//fetch product by id
Route::get('product/{id}', 'Api\ProductController@show');

//fetch top 5  reward product
Route::get('reward/product/list/{id}', 'Api\ProductController@rewardproductView');
//fetch all reward product
Route::get('reward/product', 'Api\ProductController@rewardproductList');
//fetch product by id
Route::get('reward/product/{id}', 'Api\ProductController@rewardproductShow');

//add enquery
Route::post('add/enquery', 'Api\ProductController@storeQuery');
//total wallet balance count
Route::get('wallet/balance/{id}', 'Api\UserController@walletBalance');
//QRcode scan
Route::post('QRcode', 'Api\QRcodeController@index');
//5 order history user wise 
Route::get('order/{userid}', 'Api\OrderController@index');

//reward history
Route::post('reward/history', 'Api\OrderController@reward');

//transaction history
Route::post('transaction/history', 'Api\OrderController@view');

//reward-product-order-place
Route::post('place/order', 'Api\OrderController@placeOrder');

//banner
Route::get('banner', 'Api\BannerController@index');
//about
Route::get('about', 'Api\BannerController@about');
//add complaint
Route::post('add/complaint', 'Api\ComplaintController@store');

//chat
Route::post('chat/list', 'Api\ChatController@index');
Route::post('chat/show', 'Api\ChatController@showChat');
Route::post('chat/initiate', 'Api\ChatController@store');
Route::post('chat', 'Api\ChatController@chatStore');
Route::post('chat/document', 'Api\ChatController@createDocument');
Route::post('read-chat', 'Api\ChatController@readChat');

//notification
Route::post('notification-list', 'Api\NotificationController@index');
Route::post('read-notification', 'Api\NotificationController@readNotification');
