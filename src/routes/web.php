<?php

use App\Modules\Authentication\Controllers\VerifyRegisteredUserController;
use App\Modules\Order\Controllers\CashfreeController;
use App\Modules\Order\Controllers\PayUMoneyController;
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
Route::get('/order-payment-success', function () {
    return view('payment.success');
})->name('payment_success');
Route::get('/order-payment-fail', function () {
    return view('payment.fail');
})->name('payment_fail');

Route::prefix('razorpay')->group(function () {
    Route::get('pay/{order_id}',[RazorpayController::class, 'get'])->name('make_razorpay_payment');
    Route::post('verify/{order_id}',[RazorpayController::class, 'post'])->name('verify_razorpay_payment');
});

Route::prefix('pay-u')->group(function () {
    Route::get('pay/{order_id}',[PayUMoneyController::class,'payUMoneyView'])->name('make_payu_payment');
    Route::post('response/{order_id}',[PayUMoneyController::class,'payUResponse'])->name('pay.u.response');
    Route::get('cancel',[PayUMoneyController::class,'payUCancel'])->name('pay.u.cancel');
});

Route::prefix('cashfree')->group(function () {
    Route::get('pay/{order_id}',[CashfreeController::class,'cashfreeView'])->name('make_cashfree_payment');
    Route::get('response/{order_id}',[CashfreeController::class,'cashfreeResponse'])->name('cashfree.response');
});

Route::get('pdf/{file}', function($file){
    try {
        //code...
        return response()->download(storage_path('app/public/reports/'.$file))->deleteFileAfterSend(true);
    } catch (\Throwable $th) {
        //throw $th;
        return response()->json('File not found', 404);
    }
})->name('downaload_invoice_customer');