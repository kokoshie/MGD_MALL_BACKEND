<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ProductController;
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

Route::post('sendlogindata',[AdminController::class,'send_login_data'])->name('sendlogin');

Route::post('store_category',[ProductController::class,'store_category_data'])->name('store_category');
Route::get('getCategory',[ProductController::class,'get_category_data'])->name('getCategory');

Route::post('store_subcategory',[ProductController::class,'store_subcategory_data'])->name('store_subcategory');
Route::get('getSubCategory',[ProductController::class,'get_subcategory_data'])->name('getSubCategory');

Route::post('store_second_subcategory',[ProductController::class,'store_second_subcategory_data'])->name('store_second_subcategory');
Route::post('get_second_subcategory',[ProductController::class,'get_second_subcategory_data'])->name('get_second_subcategory');

// Product
Route::post('store_product',[ProductController::class,'store_product_data'])->name('store_product');
Route::post('get_sub_category_for_product',[ProductController::class,'get_subcategory_product_data'])->name('get_sub_category_for_product');
Route::post('get_sec_sub_category_for_product',[ProductController::class,'get_sec_subcategory_product_data'])->name('get_sec_sub_category_for_product');

//paginate Category
Route::post('paginate_category',[ProductController::class,'get_paginate_category_data'])->name('paginate_category');

//store Each Item
Route::post('store_product_item',[ProductController::class,'store_each_item_data'])->name('store_product_item');




