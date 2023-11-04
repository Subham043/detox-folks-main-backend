<?php

use App\Modules\Authentication\Controllers\VerifyRegisteredUserController;
use App\Modules\Order\Controllers\PhonepeController;
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
