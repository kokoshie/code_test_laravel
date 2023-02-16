<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MasterData\CategoryController;
use App\Http\Controllers\MasterData\ProductController;
use App\Http\Controllers\SellerController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RegisterController::class)->group(function(){
    Route::post('/register', [RegisterController::class,'register']);
    Route::post('/login', [RegisterController::class,'login']);
    Route::post('/logout', [RegisterController::class,'logout']);
});

Route::middleware('auth:sanctum')->group( function () {
    Route::post('/logout', [RegisterController::class,'logout']);
    Route::get('/getCategory', [CategoryController::class,'show']);
    Route::post('/store_category', [CategoryController::class,'store']);
    Route::get('/category/{id}', [CategoryController::class,'edit']);
    Route::post('/update_category/{id}', [CategoryController::class,'update']);
    Route::delete('/delete_category/{id}', [CategoryController::class,'delete']);

    Route::get('/getProduct', [ProductController::class,'show']);
    Route::post('/store_product', [ProductController::class,'store']);
    Route::get('/product/{id}', [ProductController::class,'edit']);
    Route::post('/update_product/{id}', [ProductController::class,'update']);
    Route::delete('/delete_product/{id}', [ProductController::class,'delete']);

    Route::get('/getSeller', [SellerController::class,'show']);
    Route::post('/store_seller', [SellerController::class,'store']);
    Route::get('/seller/{id}', [SellerController::class,'edit']);
    Route::post('/update_seller/{id}', [SellerController::class,'update']);
    Route::delete('/delete_seller/{id}', [SellerController::class,'delete']);
});




