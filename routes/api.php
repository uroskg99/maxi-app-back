<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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

Route::get('/products/getAllProducts', [ProductController::class, "getAllProducts"]);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/searchv2', [ProductController::class, 'searchv2']);
Route::get('/products/{id}', [ProductController::class, 'getElementById']);

Route::post('/products/addNewProduct', [ProductController::class, 'addNewProduct']);
Route::post('/products/updateProduct', [ProductController::class, 'updateProduct']);
Route::post('/products/deleteProduct', [ProductController::class, 'deleteProduct']);

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);