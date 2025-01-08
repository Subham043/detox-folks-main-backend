<?php

use App\Exceptions\CustomExceptions\UnauthenticatedException;
use App\Modules\AboutPage\Main\Controllers\UserAboutMainController;
use App\Modules\Authentication\Controllers\UserProfileController;
use App\Modules\Authentication\Controllers\UserForgotPasswordController;
use App\Modules\Authentication\Controllers\UserLoginController;
use App\Modules\Authentication\Controllers\UserLogoutController;
use App\Modules\Authentication\Controllers\UserPasswordUpdateController;
use App\Modules\Authentication\Controllers\UserRegisterController;
use App\Modules\Authentication\Controllers\UserResendOtpController;
use App\Modules\Authentication\Controllers\UserResetPasswordController;
use App\Modules\Authentication\Controllers\VerifyRegisteredUserController;
use App\Modules\BillingAddress\Controllers\BillingAddressAllController;
use App\Modules\BillingAddress\Controllers\BillingAddressCreateController;
use App\Modules\BillingAddress\Controllers\BillingAddressDeleteController;
use App\Modules\BillingAddress\Controllers\BillingAddressDetailController;
use App\Modules\BillingAddress\Controllers\BillingAddressPaginateController;
use App\Modules\BillingAddress\Controllers\BillingAddressUpdateController;
use App\Modules\BillingInformation\Controllers\BillingInformationAllController;
use App\Modules\BillingInformation\Controllers\BillingInformationCreateController;
use App\Modules\BillingInformation\Controllers\BillingInformationDeleteController;
use App\Modules\BillingInformation\Controllers\BillingInformationDetailController;
use App\Modules\BillingInformation\Controllers\BillingInformationPaginateController;
use App\Modules\BillingInformation\Controllers\BillingInformationUpdateController;
use App\Modules\Blog\Controllers\UserBlogDetailController;
use App\Modules\Blog\Controllers\UserBlogPaginateController;
use App\Modules\Cart\Controllers\CartAllController;
use App\Modules\Cart\Controllers\CartCreateController;
use App\Modules\Cart\Controllers\CartDeleteController;
use App\Modules\Cart\Controllers\CartDetailController;
use App\Modules\Cart\Controllers\CartPaginateController;
use App\Modules\Cart\Controllers\CartUpdateController;
use App\Modules\Category\Controllers\UserCategoryDetailController;
use App\Modules\Category\Controllers\UserCategoryPaginateController;
use App\Modules\DeliverySlot\Controllers\UserDeliverySlotAllController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormCreateController;
use App\Modules\Enquiry\OrderForm\Controllers\OrderFormCreateController;
use App\Modules\Feature\Controllers\UserFeatureAllController;
use App\Modules\GlobalSearch\Controllers\UserGlobalSearchPaginateController;
use App\Modules\Legal\Controllers\UserLegalAllController;
use App\Modules\Legal\Controllers\UserLegalDetailController;
use App\Modules\Map\Controllers\MapAutoCompleteController;
use App\Modules\Map\Controllers\MapDirectionController;
use App\Modules\Map\Controllers\MapReverseGeocodingController;
use App\Modules\Order\Controllers\RecentlyOrderedProductsPaginateController;
use App\Modules\Order\Controllers\OrderAllController;
use App\Modules\Order\Controllers\OrderDetailController;
use App\Modules\Order\Controllers\OrderInvoicePdfController;
use App\Modules\Order\Controllers\OrderPaginateController;
use App\Modules\Order\Controllers\OrderPlacedDetailController;
use App\Modules\Order\Controllers\OrderPlacedPaginateController;
use App\Modules\Order\Controllers\PlaceOrderController;
use App\Modules\Product\Controllers\UserProductDetailController;
use App\Modules\Product\Controllers\UserProductPaginateController;
use App\Modules\ProductReview\Controllers\UserProductReviewCreateController;
use App\Modules\ProductReview\Controllers\UserProductReviewPaginateController;
use App\Modules\Promoter\Controllers\InstallerController;
use App\Modules\SubCategory\Controllers\UserSubCategoryDetailController;
use App\Modules\SubCategory\Controllers\UserSubCategoryPaginateController;
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
    Route::post('/login-phone', [UserLoginController::class, 'phone_post'])->name('user.login_phone');
    Route::post('/login-phone-otp', [UserLoginController::class, 'phone_otp_post'])->name('user.login_phone_otp');
    Route::post('/login-phone-password', [UserLoginController::class, 'phone_password_post'])->name('user.login_phone_password');
    Route::post('/register', [UserRegisterController::class, 'post'])->name('user.register');
    Route::post('/forgot-password', [UserForgotPasswordController::class, 'post'])->name('user.forgot_password');
    Route::post('/reset-password/{token}', [UserResetPasswordController::class, 'post', 'as' => 'reset_password.post'])->name('user.reset_password');
    Route::post('/resend-otp', [UserResendOtpController::class, 'post', 'as' => 'resend_otp.post'])->name('user.resend_otp');
});

Route::prefix('map')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/autocomplete', [MapAutoCompleteController::class, 'get'])->name('map.autocomplete');
    Route::post('/reverse', [MapReverseGeocodingController::class, 'get'])->name('map.reverse');
    Route::post('/direction', [MapDirectionController::class, 'get'])->name('map.direction');
});

Route::prefix('/email/verify')->group(function () {
    Route::post('/resend-notification', [VerifyRegisteredUserController::class, 'resend_notification', 'as' => 'resend_notification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
});

Route::prefix('contact-form')->group(function () {
    Route::post('/', [ContactFormCreateController::class, 'post'])->name('user.contact_form.create');
});

Route::prefix('testimonial')->group(function () {
    Route::get('/', [UserTestimonialAllController::class, 'get'])->name('user.testimonial.all');
});

Route::prefix('delivery-slot')->group(function () {
    Route::get('/', [UserDeliverySlotAllController::class, 'get'])->name('delivery_slot.testimonial.all');
});

Route::prefix('feature')->group(function () {
    Route::get('/', [UserFeatureAllController::class, 'get'])->name('user.feature.all');
});

Route::prefix('about-section')->group(function () {
    Route::get('/', [UserAboutMainController::class, 'get'])->name('user.about.main');
});

Route::prefix('legal')->group(function () {
    Route::get('/', [UserLegalAllController::class, 'get'])->name('user.legal.all');
    Route::get('/{slug}', [UserLegalDetailController::class, 'get'])->name('user.legal.detail');
});

Route::prefix('category')->group(function () {
    Route::get('/', [UserCategoryPaginateController::class, 'get'])->name('user.category.all');
    Route::get('/{slug}', [UserCategoryDetailController::class, 'get'])->name('user.category.detail');
});

Route::prefix('sub-category')->group(function () {
    Route::get('/', [UserSubCategoryPaginateController::class, 'get'])->name('user.sub_category.all');
    Route::get('/{slug}', [UserSubCategoryDetailController::class, 'get'])->name('user.sub_category.detail');
});

Route::prefix('blog')->group(function () {
    Route::get('/', [UserBlogPaginateController::class, 'get'])->name('user.blog.paginate');
    Route::get('/{slug}', [UserBlogDetailController::class, 'get'])->name('user.blog.detail');
});

Route::prefix('search')->group(function () {
    Route::get('/', [UserGlobalSearchPaginateController::class, 'get'])->name('user.search.paginate');
});

Route::prefix('product')->group(function () {
    Route::get('/', [UserProductPaginateController::class, 'get'])->name('user.product.paginate');
    Route::get('/{slug}', [UserProductDetailController::class, 'get'])->name('user.product.detail');
    Route::get('/{slug}/reviews', [UserProductReviewPaginateController::class, 'get'])->name('user.product.reviews');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('profile')->group(function () {
        Route::get('/', [UserProfileController::class, 'get', 'as' => 'profile.get'])->name('user.profile.get');
        Route::post('/update', [UserProfileController::class, 'post', 'as' => 'profile.post'])->name('user.profile.post');
        Route::post('/update-password', [UserPasswordUpdateController::class, 'post', 'as' => 'password.post'])->name('user.password.post');
    });

    Route::prefix('/promotion')->group(function () {
        Route::get('/', [InstallerController::class, 'get', 'as' => 'promotion.get']);
        Route::post('/', [InstallerController::class, 'post', 'as' => 'promotion.post']);
    });

    Route::prefix('/billing-address')->group(function () {
        Route::get('/', [BillingAddressPaginateController::class, 'get', 'as' => 'billing_address.paginate.get'])->name('billing_address.paginate.get');
        Route::get('/all', [BillingAddressAllController::class, 'get', 'as' => 'billing_address.all.get'])->name('billing_address.all.get');
        Route::post('/create', [BillingAddressCreateController::class, 'post', 'as' => 'billing_address.create.get'])->name('billing_address.create.post');
        Route::post('/update/{id}', [BillingAddressUpdateController::class, 'post', 'as' => 'billing_address.update.get'])->name('billing_address.update.post');
        Route::get('/detail/{id}', [BillingAddressDetailController::class, 'get', 'as' => 'billing_address.detail.get'])->name('billing_address.detail.get');
        Route::delete('/delete/{id}', [BillingAddressDeleteController::class, 'delete', 'as' => 'billing_address.delete.get'])->name('billing_address.delete.get');
    });

    Route::prefix('/billing-information')->group(function () {
        Route::get('/', [BillingInformationPaginateController::class, 'get', 'as' => 'billing_information.paginate.get'])->name('billing_information.paginate.get');
        Route::get('/all', [BillingInformationAllController::class, 'get', 'as' => 'billing_information.all.get'])->name('billing_information.all.get');
        Route::post('/create', [BillingInformationCreateController::class, 'post', 'as' => 'billing_information.create.get'])->name('billing_information.create.post');
        Route::post('/update/{id}', [BillingInformationUpdateController::class, 'post', 'as' => 'billing_information.update.get'])->name('billing_information.update.post');
        Route::get('/detail/{id}', [BillingInformationDetailController::class, 'get', 'as' => 'billing_information.detail.get'])->name('billing_information.detail.get');
        Route::delete('/delete/{id}', [BillingInformationDeleteController::class, 'delete', 'as' => 'billing_information.delete.get'])->name('billing_information.delete.get');
    });

    Route::prefix('/cart')->group(function () {
        Route::get('/', [CartPaginateController::class, 'get', 'as' => 'cart.paginate.get'])->name('cart.paginate.get');
        Route::get('/all', [CartAllController::class, 'get', 'as' => 'cart.all.get'])->name('cart.all.get');
        Route::post('/create', [CartCreateController::class, 'post', 'as' => 'cart.create.get'])->name('cart.create.post');
        Route::post('/update/{id}', [CartUpdateController::class, 'post', 'as' => 'cart.update.get'])->name('cart.update.post');
        Route::get('/detail/{id}', [CartDetailController::class, 'get', 'as' => 'cart.detail.get'])->name('cart.detail.get');
        Route::delete('/delete/{id}', [CartDeleteController::class, 'delete', 'as' => 'cart.delete.get'])->name('cart.delete.get');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderPaginateController::class, 'get', 'as' => 'order.paginate.get'])->name('order.paginate.get');
        Route::get('/all', [OrderAllController::class, 'get', 'as' => 'order.all.get'])->name('order.all.get');
        Route::get('/latest-product-item', [RecentlyOrderedProductsPaginateController::class, 'get', 'as' => 'order.latest_product.get'])->name('order.latest_product.get');
        Route::get('/placed-paginate', [OrderPlacedPaginateController::class, 'get', 'as' => 'order.placed_paginate.get'])->name('order.placed_paginate.get');
        Route::post('/place', [PlaceOrderController::class, 'post', 'as' => 'order.place.get'])->name('order.place.post');
        Route::get('/detail/{id}', [OrderDetailController::class, 'get', 'as' => 'order.detail.get'])->name('order.detail.get');
        Route::get('/pdf/{id}', [OrderInvoicePdfController::class, 'get', 'as' => 'order.pdf.get'])->name('order.pdf.get');
        Route::get('/placed-detail/{id}', [OrderPlacedDetailController::class, 'get', 'as' => 'order.placed_detail.get'])->name('order.placed_detail.get');
        Route::post('/enquiry/{order_id}', [OrderFormCreateController::class, 'post', 'as' => 'order.enquiry.post'])->name('order.enquiry.post');
    });

    Route::prefix('product')->group(function () {
        Route::post('/{slug}/reviews/create', [UserProductReviewCreateController::class, 'post'])->name('user.product.reviews_create');
    });

    Route::post('/auth/logout', [UserLogoutController::class, 'post', 'as' => 'logout'])->name('user.logout');

});

Route::get('/unauthenticated', function () {
    throw new UnauthenticatedException("Unauthenticated", 401);
 })->name('unauthenticated');
