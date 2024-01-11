<?php

use App\Modules\Authentication\Controllers\VerifyRegisteredUserController;
use App\Modules\Order\Controllers\PhonepeController;
use App\Modules\Order\Controllers\RazorpayController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/email/verify')->group(function () {
    Route::get('/{id}/{hash}', [VerifyRegisteredUserController::class, 'verify_email', 'as' => 'verify_email'])->name('verification.verify');
});

Route::post('/phonepe', [PhonepeController::class, 'post', 'as' => 'post'])->name('phonepe_response');
Route::get('/razorpay-order-payment-success', function () {
    return view('razorpay.success');
})->name('razorpay_payment_success');
Route::get('/make-razorpay-order-payment/{order_id}', [RazorpayController::class, 'get'])->name('make_razorpay_payment');
Route::post('/verify-razorpay-order-payment/{order_id}', [RazorpayController::class, 'post'])->name('verify_razorpay_payment');
