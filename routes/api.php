<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\BillsController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CommentControler;
use App\Http\Controllers\API\InfoShopController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RolesController;
use App\Http\Controllers\API\DiscountController;
use App\Http\Controllers\API\NewPasswordController;

use App\Models\Review;

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


Route::post('register',[AuthController::class,'register']);

Route::post('login',[AuthController::class,'login']);

Route::get('users',[AuthController::class,'user']);



Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function(){

    Route::get('/checkingAuthenticated',function(){
        return response()->json(['messeage'=>"You are in",'status'=>200],200);
    });

    //category
    Route::post('store-category',[CategoryController::class,'store']);
    Route::get('view-category',[CategoryController::class,'index']);
    Route::get('edit-category/{id}',[CategoryController::class,'edit']);
    Route::put('update-category/{id}',[CategoryController::class,'update']);
    Route::delete('delete-category/{id}',[CategoryController::class,'destroy']);
   

 //Products
    Route::post('store-product',[ProductController::class,'store']);
    Route::get('view-product',[ProductController::class,'index']);
    Route::get('edit-product/{id}',[ProductController::class,'edit']);
    Route::post('update-product/{id}',[ProductController::class,'update']);
    Route::delete('delete-product/{id}',[ProductController::class,'destroy']);


    Route::post('store-user',[AuthController::class,'store']);
    Route::get('view-users',[AuthController::class,'index']);
    Route::get('edit-user/{id}',[AuthController::class,'edit']);
    Route::post('update-user/{id}',[AuthController::class,'update']);
    Route::delete('delete-user/{id}',[AuthController::class,'destroy']);  

    Route::get('roles',[RolesController::class,'index']);

});



Route::get('view-product',[ProductController::class,'index']);
Route::get('view-product-status',[ProductController::class,'getStatus']);
Route::get('slug-product/{slug}',[ProductController::class,'getSlug']);

Route::get('view-bill',[BillsController::class,'index']);
Route::post('store-bill',[BillsController::class,'store']);

Route::post('view-bill-order',[BillsController::class,'indexGroupBy']);


Route::get('get-bill-detail/{id}',[BillsController::class,'getBillsDetail']);
Route::get('get-bill/{id}',[BillsController::class,'getBill']);
Route::post('update-bill-status',[BillsController::class,'updateStatus']);
Route::get('get-bill-user',[BillsController::class,'getBillsUser']);

Route::get('get-bill-group',[BillsController::class,'getBillsAllDetail']);





Route::post('store-review',[ReviewController::class,'store']);

Route::post('store-comment',[CommentControler::class,'store']);
Route::post('store-reply-comment',[CommentControler::class,'storeReply']);
Route::get('view-comment',[CommentControler::class,'index']);

Route::post('update-customer',[AuthController::class,'updateUser']);
Route::post('reset-pass-customer',[AuthController::class,'resetPassword']);

Route::post('forgot-password',[NewPasswordController::class,'forgotPassword'])->middleware('guest')->name('password.request');;
Route::post('reset-password',[NewPasswordController::class,'resetPassword'])->middleware('guest')->name('password.update');



Route::get('slug-category/{slug}',[CategoryController::class,'getSlug']);
Route::get('view-category',[CategoryController::class,'index']);
Route::get('all-category',[CategoryController::class,'allcategory']);

// banner

Route::post('store-banner',[BannerController::class,'store']);
Route::get('view-banner',[BannerController::class,'index']);
Route::get('edit-banner/{id}',[BannerController::class,'edit']);
Route::post('update-banner/{id}',[BannerController::class,'update']);
Route::delete('delete-banner/{id}',[BannerController::class,'destroy']); 

// discount
Route::post('store-discount',[DiscountController::class,'store']);
Route::get('view-discount',[DiscountController::class,'index']);
Route::get('edit-discount/{id}',[DiscountController::class,'edit']);
Route::post('update-discount/{id}',[DiscountController::class,'update']);
Route::delete('delete-discount/{id}',[DiscountController::class,'destroy']); 

// info shop
Route::get('get-infoshop',[InfoShopController::class,'getInfoShop']);
Route::post('update-infoshop',[InfoShopController::class,'update']);

Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});