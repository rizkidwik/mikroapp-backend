<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ConfigController;
use App\Http\Controllers\API\MikrotikController;
use App\Http\Controllers\API\ProductController;

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
Route::get('config',[ConfigController::class,'index']);
Route::post('config',[ConfigController::class,'store']);
Route::put('config/{id}',[ConfigController::class,'update']);
Route::delete('config/{id}',[ConfigController::class,'destroy']);

Route::get('/cek-koneksi',[MikrotikController::class,'cek_koneksi']);
Route::get('/cek-hotspot',[MikrotikController::class,'cek_hotspot']);
Route::get('/interface',[MikrotikController::class,'interface']);
Route::get('/get-user-profile',[MikrotikController::class,'get_user_profile']);
Route::get('/generate-voucher',[MikrotikController::class,'generate_voucher']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);
// Route::resource('order', OrderController::class);
Route::post('/checkout',[OrderController::class,'checkout']);

});

Route::get('/order/{id}',[OrderController::class,'status']);
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('/generate',[OrderController::class,'generate_voucher']);

Route::get('products',[ProductController::class,'all']);
