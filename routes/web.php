<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\Admin\RateController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\PaymentCallbackController;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['auth'])->group(function(){
    Route::get('/',[DashboardController::class,'index']);
    // Route::get('/product',[DashboardController::class,'product']);
    Route::resource('order', OrderController::class);
    Route::post('order/{id}',[OrderController::class,'update']);
});



Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
    Route::get('/', function () {
        return view('home');
    })->name('dashboard');
    Route::resource('hotspot', HotspotController::class);
    Route::resource('product', ProductController::class);
    Route::resource('voucher', VoucherController::class);
    Route::resource('rates', RateController::class);
    Route::resource('config', ConfigController::class);
    // Route::resource('payment', Admin\OrderController::class)->only(['index','show']);
});




Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);
Route::get('midtrans/success', [PaymentCallbackController::class, 'success']);


require __DIR__.'/auth.php';
