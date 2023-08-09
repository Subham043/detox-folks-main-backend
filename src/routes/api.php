<?php

use App\Exceptions\CustomExceptions\UnauthenticatedException;
use App\Modules\Authentication\Controllers\UserProfileController;
use App\Modules\Authentication\Controllers\UserForgotPasswordController;
use App\Modules\Authentication\Controllers\UserLoginController;
use App\Modules\Authentication\Controllers\UserPasswordUpdateController;
use App\Modules\Authentication\Controllers\UserRegisterController;
use App\Modules\Authentication\Controllers\VerifyRegisteredUserController;
use App\Modules\Blog\Controllers\UserBlogDetailController;
use App\Modules\Blog\Controllers\UserBlogPaginateController;
use App\Modules\Counter\Controllers\UserCounterAllController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormCreateController;
use App\Modules\Legal\Controllers\UserLegalAllController;
use App\Modules\Legal\Controllers\UserLegalDetailController;
use App\Modules\Partner\Controllers\UserPartnerAllController;
use App\Modules\Settings\Controllers\General\UserGeneralController;
use App\Modules\Testimonial\Controllers\UserTestimonialAllController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [UserLoginController::class, 'post'])->name('user.login');
    Route::post('/register', [UserRegisterController::class, 'post'])->name('user.register');
    Route::post('/forgot-password', [UserForgotPasswordController::class, 'post'])->name('user.forgot_password');
});

Route::prefix('/email/verify')->group(function () {
    Route::post('/resend-notification', [VerifyRegisteredUserController::class, 'resend_notification', 'as' => 'resend_notification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
    Route::get('/{id}/{hash}', [VerifyRegisteredUserController::class, 'verify_email', 'as' => 'verify_email'])->middleware(['signed'])->name('verification.verify');
});

Route::prefix('contact-form')->group(function () {
    Route::post('/', [ContactFormCreateController::class, 'post'])->name('user.contact_form.create');
});

Route::prefix('counter')->group(function () {
    Route::get('/', [UserCounterAllController::class, 'get'])->name('user.counter.all');
});

Route::prefix('partner')->group(function () {
    Route::get('/', [UserPartnerAllController::class, 'get'])->name('user.partner.all');
});

Route::prefix('testimonial')->group(function () {
    Route::get('/', [UserTestimonialAllController::class, 'get'])->name('user.testimonial.all');
});

Route::prefix('legal')->group(function () {
    Route::get('/', [UserLegalAllController::class, 'get'])->name('user.legal.all');
    Route::get('/{slug}', [UserLegalDetailController::class, 'get'])->name('user.legal.detail');
});

Route::prefix('website-detail')->group(function () {
    Route::get('/', [UserGeneralController::class, 'get'])->name('user.website-detail.all');
});

Route::prefix('blog')->group(function () {
    Route::get('/', [UserBlogPaginateController::class, 'get'])->name('user.blog.paginate');
    Route::get('/{slug}', [UserBlogDetailController::class, 'get'])->name('user.blog.detail');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('profile')->group(function () {
        Route::get('/', [UserProfileController::class, 'get', 'as' => 'profile.get'])->name('user.profile.get');
        Route::post('/update', [UserProfileController::class, 'post', 'as' => 'profile.post'])->name('user.profile.post');
        Route::post('/update-password', [UserPasswordUpdateController::class, 'post', 'as' => 'password.post'])->name('user.password.post');
    });

});

Route::get('/unauthenticated', function () {
    throw new UnauthenticatedException("Unauthenticated", 401);
 })->name('unauthenticated');
