<?php

use App\Http\Controllers\ProductController;
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

Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('products/search', [ProductController::class, 'search']);
Route::get('/products/register', [ProductController::class, 'getRegister']);
Route::post('/products/upload', [ProductController::class, 'upload']);
Route::get('/products/{productId}', [ProductController::class, 'getDetail']);
Route::put('/products/{productId}/update', [ProductController::class, 'update']);
Route::get('/products/{productId}/delete', [ProductController::class, 'delete']);