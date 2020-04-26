<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('profile-user', 'API\UserController@profileUser');
    Route::post('update-profile', 'API\UserController@updateProfileUser');

    Route::post('place-order', 'API\UserController@placeOrder');
    Route::get('cart/{id?}', 'API\UserController@getCart');
});

Route::post('change-password', 'API\UserController@changePassword');
Route::get('add-to-cart', 'API\UserController@addToCart');
Route::get('/do-order/{total?}/{orderAmount?}', 'API\UserController@doOrder');
Route::post('login', 'API\UserController@authUser');
Route::post('register-user', 'API\UserController@registerAsUser');
Route::post('register-vendor', 'API\UserController@registerAsVendor');
Route::post('forget-password', 'API\UserController@forgetPassword');
Route::post('forget-password-done', 'API\UserController@forgetPasswordDone');
Route::get('fetch-product', 'API\ProductController@fetchProduct');
Route::get('product-detail/{id?}', 'API\ProductController@productDetail');

Route::get('search-products', 'API\UserController@searchProducts');
Route::post('add-product', 'API\ProductController@addProduct');
//Route::get('cart/{id?}', 'API\UserController@getCart');

