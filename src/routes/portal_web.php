<?php

use App\Modules\AboutPage\Main\Controllers\AboutMainController;
use App\Modules\Authentication\Controllers\AdminRegisterController;
use App\Modules\Authentication\Controllers\PasswordUpdateController;
use App\Modules\Authentication\Controllers\ForgotPasswordController;
use App\Modules\Authentication\Controllers\LoginController;
use App\Modules\Authentication\Controllers\LogoutController;
use App\Modules\Authentication\Controllers\ProfileController;
use App\Modules\Authentication\Controllers\ResetPasswordController;
use App\Modules\Authentication\Controllers\VerifyRegisteredAdminController;
use App\Modules\Dashboard\Controllers\DashboardController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormDeleteController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormExcelController;
use App\Modules\Enquiry\ContactForm\Controllers\ContactFormPaginateController;
use App\Modules\Legal\Controllers\LegalPaginateController;
use App\Modules\Legal\Controllers\LegalUpdateController;
use App\Modules\Blog\Controllers\BlogCreateController;
use App\Modules\Blog\Controllers\BlogDeleteController;
use App\Modules\Blog\Controllers\BlogPaginateController;
use App\Modules\Blog\Controllers\BlogUpdateController;
use App\Modules\Category\Controllers\CategoryApiController;
use App\Modules\Category\Controllers\CategoryCreateController;
use App\Modules\Category\Controllers\CategoryDeleteController;
use App\Modules\Category\Controllers\CategoryExcelController;
use App\Modules\Category\Controllers\CategoryPaginateController;
use App\Modules\Category\Controllers\CategoryUpdateController;
use App\Modules\Charge\Controllers\ChargeCreateController;
use App\Modules\Charge\Controllers\ChargeDeleteController;
use App\Modules\Charge\Controllers\ChargePaginateController;
use App\Modules\Charge\Controllers\ChargeUpdateController;
use App\Modules\DeliveryManagement\Controllers\AssignDeliveryAgentController;
use App\Modules\DeliveryManagement\Controllers\AssignedOrderController;
use App\Modules\DeliveryManagement\Controllers\AssignedOrderForAgentPaginateController;
use App\Modules\DeliveryManagement\Controllers\DeliveryAgentPaginateController;
use App\Modules\DeliverySlot\Controllers\DeliverySlotCreateController;
use App\Modules\DeliverySlot\Controllers\DeliverySlotDeleteController;
use App\Modules\DeliverySlot\Controllers\DeliverySlotPaginateController;
use App\Modules\DeliverySlot\Controllers\DeliverySlotUpdateController;
use App\Modules\Enquiry\OrderForm\Controllers\OrderFormDeleteController;
use App\Modules\Enquiry\OrderForm\Controllers\OrderFormExcelController;
use App\Modules\Enquiry\OrderForm\Controllers\OrderFormPaginateController;
use App\Modules\Feature\Controllers\FeatureCreateController;
use App\Modules\Feature\Controllers\FeatureDeleteController;
use App\Modules\Feature\Controllers\FeaturePaginateController;
use App\Modules\Feature\Controllers\FeatureUpdateController;
use App\Modules\Settings\Controllers\ActivityLog\ActivityLogDetailController;
use App\Modules\Settings\Controllers\ActivityLog\ActivityLogPaginateController;
use App\Modules\Settings\Controllers\ErrorLogController;
use App\Modules\User\Controllers\UserCreateController;
use App\Modules\User\Controllers\UserDeleteController;
use App\Modules\User\Controllers\UserPaginateController;
use App\Modules\User\Controllers\UserUpdateController;
use App\Modules\Testimonial\Controllers\TestimonialCreateController;
use App\Modules\Testimonial\Controllers\TestimonialDeleteController;
use App\Modules\Testimonial\Controllers\TestimonialPaginateController;
use App\Modules\Testimonial\Controllers\TestimonialUpdateController;
use App\Modules\Order\Controllers\OrderAdminCancelController;
use App\Modules\Order\Controllers\OrderAdminDetailController;
use App\Modules\Order\Controllers\OrderAdminPaginateController;
use App\Modules\Order\Controllers\OrderAdminCollectPaymentController;
use App\Modules\Order\Controllers\OrderAdminExcelController;
use App\Modules\Order\Controllers\OrderAdminInvoicePdfController;
use App\Modules\Order\Controllers\OrderAdminStatusController;
use App\Modules\Product\Controllers\ProductCreateController;
use App\Modules\Product\Controllers\ProductDeleteController;
use App\Modules\Product\Controllers\ProductExcelController;
use App\Modules\Product\Controllers\ProductPaginateController;
use App\Modules\Product\Controllers\ProductUpdateController;
use App\Modules\ProductColor\Controllers\ProductColorCreateController;
use App\Modules\ProductColor\Controllers\ProductColorDeleteController;
use App\Modules\ProductColor\Controllers\ProductColorPaginateController;
use App\Modules\ProductColor\Controllers\ProductColorUpdateController;
use App\Modules\ProductImage\Controllers\ProductImageCreateController;
use App\Modules\ProductImage\Controllers\ProductImageDeleteController;
use App\Modules\ProductImage\Controllers\ProductImagePaginateController;
use App\Modules\ProductImage\Controllers\ProductImageUpdateController;
use App\Modules\ProductPrice\Controllers\ProductPriceCreateController;
use App\Modules\ProductPrice\Controllers\ProductPriceDeleteController;
use App\Modules\ProductPrice\Controllers\ProductPricePaginateController;
use App\Modules\ProductPrice\Controllers\ProductPriceUpdateController;
use App\Modules\ProductReview\Controllers\ProductReviewCreateController;
use App\Modules\ProductReview\Controllers\ProductReviewDeleteController;
use App\Modules\ProductReview\Controllers\ProductReviewPaginateController;
use App\Modules\ProductReview\Controllers\ProductReviewUpdateController;
use App\Modules\ProductSpecification\Controllers\ProductSpecificationCreateController;
use App\Modules\ProductSpecification\Controllers\ProductSpecificationDeleteController;
use App\Modules\ProductSpecification\Controllers\ProductSpecificationPaginateController;
use App\Modules\ProductSpecification\Controllers\ProductSpecificationUpdateController;
use App\Modules\Promoter\Controllers\PromoterBankInformationController;
use App\Modules\Promoter\Controllers\PromoterInstalledController;
use App\Modules\Promoter\Controllers\PromoterInstallerPaginateController;
use App\Modules\Promoter\Controllers\PromoterPaginateController;
use App\Modules\Promoter\Controllers\PromoterSelfBankInformationController;
use App\Modules\SubCategory\Controllers\SubCategoryCreateController;
use App\Modules\SubCategory\Controllers\SubCategoryDeleteController;
use App\Modules\SubCategory\Controllers\SubCategoryExcelController;
use App\Modules\SubCategory\Controllers\SubCategoryPaginateController;
use App\Modules\SubCategory\Controllers\SubCategoryUpdateController;
use App\Modules\TextEditorImage\Controllers\TextEditorImageController;
use App\Modules\User\Controllers\UserExcelController;
use App\Modules\WarehouseManagement\Controllers\WarehouseOrderDetailController;
use App\Modules\WarehouseManagement\Controllers\WarehouseOrderPaginateController;
use App\Modules\WarehouseManagement\Controllers\WarehouseOrderStatusUpdateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'login_otp', 'as' => 'login_otp.get'])->name('login_otp.get');
    Route::post('/authenticate-otp', [LoginController::class, 'otp_post', 'as' => 'login_otp.post'])->name('login_otp.post');
    Route::get('/login-email', [LoginController::class, 'get', 'as' => 'login_email.get'])->name('login_email.get');
    Route::post('/authenticate', [LoginController::class, 'post', 'as' => 'login.post'])->name('login.post');
    Route::get('/login-phone', [LoginController::class, 'login_phone', 'as' => 'login_phone.get'])->name('login_phone.get');
    Route::post('/authenticate-phone', [LoginController::class, 'phone_post', 'as' => 'login_phone.post'])->name('login_phone.post');
    Route::post('/authenticate-send-otp', [LoginController::class, 'send_otp', 'as' => 'login_send_otp.post'])->name('login_send_otp.post');
    Route::get('/register', [AdminRegisterController::class, 'get', 'as' => 'register.get'])->name('register.get');
    Route::post('/register', [AdminRegisterController::class, 'post', 'as' => 'register.post'])->name('register.post');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'get', 'as' => 'forgot_password.get'])->name('forgot_password.get');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'post', 'as' => 'forgot_password.post'])->name('forgot_password.post');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'get', 'as' => 'reset_password.get'])->name('reset_password.get');
    Route::post('/reset-password/{token}', [ResetPasswordController::class, 'post', 'as' => 'reset_password.post'])->name('reset_password.post');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'get', 'as' => 'dashboard.get'])->name('dashboard.get');

    Route::middleware(['role:Super-Admin'])->prefix('/logs')->group(function () {
        Route::get('/error', [ErrorLogController::class, 'get', 'as' => 'error_log.get'])->name('error_log.get');
        Route::prefix('/activity')->group(function () {
            Route::get('/', [ActivityLogPaginateController::class, 'get', 'as' => 'activity_log.paginate.get'])->name('activity_log.paginate.get');
            Route::get('/{id}', [ActivityLogDetailController::class, 'get', 'as' => 'activity_log.detail.get'])->name('activity_log.detail.get');

        });
    });

    Route::middleware(['role:Super-Admin|Staff'])->prefix('/enquiries')->group(function () {
        Route::prefix('/contact-form')->group(function () {
            Route::get('/', [ContactFormPaginateController::class, 'get', 'as' => 'enquiry.contact_form.paginate.get'])->name('enquiry.contact_form.paginate.get');
            Route::get('/excel', [ContactFormExcelController::class, 'get', 'as' => 'enquiry.contact_form.excel.get'])->name('enquiry.contact_form.excel.get');
            Route::get('/delete/{id}', [ContactFormDeleteController::class, 'get', 'as' => 'enquiry.contact_form.delete.get'])->name('enquiry.contact_form.delete.get');
        });
        Route::prefix('/order-form')->group(function () {
            Route::get('/', [OrderFormPaginateController::class, 'get', 'as' => 'enquiry.order_form.paginate.get'])->name('enquiry.order_form.paginate.get');
            Route::get('/excel', [OrderFormExcelController::class, 'get', 'as' => 'enquiry.order_form.excel.get'])->name('enquiry.order_form.excel.get');
            Route::get('/delete/{id}', [OrderFormDeleteController::class, 'get', 'as' => 'enquiry.order_form.delete.get'])->name('enquiry.order_form.delete.get');
        });
    });

    Route::middleware(['role:Super-Admin|Content Manager'])->prefix('/content-management')->group(function () {
        Route::prefix('/legal-pages')->group(function () {
            Route::get('/', [LegalPaginateController::class, 'get', 'as' => 'legal.paginate.get'])->name('legal.paginate.get');
            Route::get('/update/{slug}', [LegalUpdateController::class, 'get', 'as' => 'legal.update.get'])->name('legal.update.get');
            Route::post('/update/{slug}', [LegalUpdateController::class, 'post', 'as' => 'legal.update.post'])->name('legal.update.post');
        });
        Route::prefix('/blog')->group(function () {
            Route::get('/', [BlogPaginateController::class, 'get', 'as' => 'blog.paginate.get'])->name('blog.paginate.get');
            Route::get('/create', [BlogCreateController::class, 'get', 'as' => 'blog.create.get'])->name('blog.create.get');
            Route::post('/create', [BlogCreateController::class, 'post', 'as' => 'blog.create.post'])->name('blog.create.post');
            Route::get('/update/{id}', [BlogUpdateController::class, 'get', 'as' => 'blog.update.get'])->name('blog.update.get');
            Route::post('/update/{id}', [BlogUpdateController::class, 'post', 'as' => 'blog.update.post'])->name('blog.update.post');
            Route::get('/delete/{id}', [BlogDeleteController::class, 'get', 'as' => 'blog.delete.get'])->name('blog.delete.get');
        });
        Route::prefix('/testimonial')->group(function () {
            Route::get('/', [TestimonialPaginateController::class, 'get', 'as' => 'testimonial.paginate.get'])->name('testimonial.paginate.get');
            Route::get('/create', [TestimonialCreateController::class, 'get', 'as' => 'testimonial.create.get'])->name('testimonial.create.get');
            Route::post('/create', [TestimonialCreateController::class, 'post', 'as' => 'testimonial.create.post'])->name('testimonial.create.post');
            Route::get('/update/{id}', [TestimonialUpdateController::class, 'get', 'as' => 'testimonial.update.get'])->name('testimonial.update.get');
            Route::post('/update/{id}', [TestimonialUpdateController::class, 'post', 'as' => 'testimonial.update.post'])->name('testimonial.update.post');
            Route::get('/delete/{id}', [TestimonialDeleteController::class, 'get', 'as' => 'testimonial.delete.get'])->name('testimonial.delete.get');
        });
        Route::prefix('/about-page')->group(function () {
            Route::get('/main', [AboutMainController::class, 'get', 'as' => 'about.main.get'])->name('about.main.get');
            Route::post('/main', [AboutMainController::class, 'post', 'as' => 'about.main.post'])->name('about.main.post');
        });

        Route::prefix('/feature')->group(function () {
            Route::get('/', [FeaturePaginateController::class, 'get', 'as' => 'feature.paginate.get'])->name('feature.paginate.get');
            Route::get('/create', [FeatureCreateController::class, 'get', 'as' => 'feature.create.get'])->name('feature.create.get');
            Route::post('/create', [FeatureCreateController::class, 'post', 'as' => 'feature.create.post'])->name('feature.create.post');
            Route::get('/update/{id}', [FeatureUpdateController::class, 'get', 'as' => 'feature.update.get'])->name('feature.update.get');
            Route::post('/update/{id}', [FeatureUpdateController::class, 'post', 'as' => 'feature.update.post'])->name('feature.update.post');
            Route::get('/delete/{id}', [FeatureDeleteController::class, 'get', 'as' => 'feature.delete.get'])->name('feature.delete.get');
        });
    });


    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'get', 'as' => 'profile.get'])->name('profile.get');
        Route::post('/update', [ProfileController::class, 'post', 'as' => 'profile.post'])->name('profile.post');
        Route::get('/profile-password-update', [PasswordUpdateController::class, 'get', 'as' => 'password.get'])->name('password.get');
        Route::post('/profile-password-update', [PasswordUpdateController::class, 'post', 'as' => 'password.post'])->name('password.post');
        Route::get('/resend-email-verify-notification', [VerifyRegisteredAdminController::class, 'resend_notification', 'as' => 'resend_notification'])->middleware(['throttle:6,1'])->name('admin_email.verification.send');
    });

    Route::middleware(['role:Super-Admin'])->prefix('/user')->group(function () {
        Route::get('/', [UserPaginateController::class, 'get', 'as' => 'user.paginate.get'])->name('user.paginate.get');
        Route::get('/excel', [UserExcelController::class, 'get', 'as' => 'user.excel.get'])->name('user.excel.get');
        Route::get('/create', [UserCreateController::class, 'get', 'as' => 'user.create.get'])->name('user.create.get');
        Route::post('/create', [UserCreateController::class, 'post', 'as' => 'user.create.get'])->name('user.create.post');
        Route::get('/update/{id}', [UserUpdateController::class, 'get', 'as' => 'user.update.get'])->name('user.update.get');
        Route::post('/update/{id}', [UserUpdateController::class, 'post', 'as' => 'user.update.get'])->name('user.update.post');
        Route::get('/delete/{id}', [UserDeleteController::class, 'get', 'as' => 'user.delete.get'])->name('user.delete.get');
    });

    Route::middleware(['role:Super-Admin|Inventory Manager'])->prefix('/product-management')->group(function () {
        Route::prefix('/category')->group(function () {
            Route::get('/', [CategoryPaginateController::class, 'get', 'as' => 'category.paginate.get'])->name('category.paginate.get');
            Route::get('/excel', [CategoryExcelController::class, 'get', 'as' => 'category.excel.get'])->name('category.excel.get');
            Route::get('/create', [CategoryCreateController::class, 'get', 'as' => 'category.create.get'])->name('category.create.get');
            Route::post('/create', [CategoryCreateController::class, 'post', 'as' => 'category.create.post'])->name('category.create.post');
            Route::get('/update/{id}', [CategoryUpdateController::class, 'get', 'as' => 'category.update.get'])->name('category.update.get');
            Route::post('/update/{id}', [CategoryUpdateController::class, 'post', 'as' => 'category.update.post'])->name('category.update.post');
            Route::get('/delete/{id}', [CategoryDeleteController::class, 'get', 'as' => 'category.delete.get'])->name('category.delete.get');
            Route::post('/api', [CategoryApiController::class, 'post', 'as' => 'category.api.post'])->name('category.api.post');
        });

        Route::prefix('/sub-category')->group(function () {
            Route::get('/', [SubCategoryPaginateController::class, 'get', 'as' => 'sub_category.paginate.get'])->name('sub_category.paginate.get');
            Route::get('/excel', [SubCategoryExcelController::class, 'get', 'as' => 'sub_category.excel.get'])->name('sub_category.excel.get');
            Route::get('/create', [SubCategoryCreateController::class, 'get', 'as' => 'sub_category.create.get'])->name('sub_category.create.get');
            Route::post('/create', [SubCategoryCreateController::class, 'post', 'as' => 'sub_category.create.post'])->name('sub_category.create.post');
            Route::get('/update/{id}', [SubCategoryUpdateController::class, 'get', 'as' => 'sub_category.update.get'])->name('sub_category.update.get');
            Route::post('/update/{id}', [SubCategoryUpdateController::class, 'post', 'as' => 'sub_category.update.post'])->name('sub_category.update.post');
            Route::get('/delete/{id}', [SubCategoryDeleteController::class, 'get', 'as' => 'sub_category.delete.get'])->name('sub_category.delete.get');
        });

        Route::prefix('/product')->group(function () {
            Route::get('/', [ProductPaginateController::class, 'get', 'as' => 'product.paginate.get'])->name('product.paginate.get');
            Route::get('/excel', [ProductExcelController::class, 'get', 'as' => 'product.excel.get'])->name('product.excel.get');
            Route::get('/create', [ProductCreateController::class, 'get', 'as' => 'product.create.get'])->name('product.create.get');
            Route::post('/create', [ProductCreateController::class, 'post', 'as' => 'product.create.post'])->name('product.create.post');
            Route::get('/update/{id}', [ProductUpdateController::class, 'get', 'as' => 'product.update.get'])->name('product.update.get');
            Route::post('/update/{id}', [ProductUpdateController::class, 'post', 'as' => 'product.update.post'])->name('product.update.post');
            Route::get('/delete/{id}', [ProductDeleteController::class, 'get', 'as' => 'product.delete.get'])->name('product.delete.get');
            Route::prefix('/{product_id}')->group(function () {
                Route::prefix('/specification')->group(function () {
                    Route::get('/', [ProductSpecificationPaginateController::class, 'get', 'as' => 'product_specification.paginate.get'])->name('product_specification.paginate.get');
                    Route::get('/create', [ProductSpecificationCreateController::class, 'get', 'as' => 'product_specification.create.get'])->name('product_specification.create.get');
                    Route::post('/create', [ProductSpecificationCreateController::class, 'post', 'as' => 'product_specification.create.post'])->name('product_specification.create.post');
                    Route::get('/update/{id}', [ProductSpecificationUpdateController::class, 'get', 'as' => 'product_specification.update.get'])->name('product_specification.update.get');
                    Route::post('/update/{id}', [ProductSpecificationUpdateController::class, 'post', 'as' => 'product_specification.update.post'])->name('product_specification.update.post');
                    Route::get('/delete/{id}', [ProductSpecificationDeleteController::class, 'get', 'as' => 'product_specification.delete.get'])->name('product_specification.delete.get');
                });
                Route::prefix('/review')->group(function () {
                    Route::get('/', [ProductReviewPaginateController::class, 'get', 'as' => 'product_review.paginate.get'])->name('product_review.paginate.get');
                    Route::get('/create', [ProductReviewCreateController::class, 'get', 'as' => 'product_review.create.get'])->name('product_review.create.get');
                    Route::post('/create', [ProductReviewCreateController::class, 'post', 'as' => 'product_review.create.post'])->name('product_review.create.post');
                    Route::get('/update/{id}', [ProductReviewUpdateController::class, 'get', 'as' => 'product_review.update.get'])->name('product_review.update.get');
                    Route::post('/update/{id}', [ProductReviewUpdateController::class, 'post', 'as' => 'product_review.update.post'])->name('product_review.update.post');
                    Route::get('/delete/{id}', [ProductReviewDeleteController::class, 'get', 'as' => 'product_review.delete.get'])->name('product_review.delete.get');
                });
                Route::prefix('/color')->group(function () {
                    Route::get('/', [ProductColorPaginateController::class, 'get', 'as' => 'product_color.paginate.get'])->name('product_color.paginate.get');
                    Route::get('/create', [ProductColorCreateController::class, 'get', 'as' => 'product_color.create.get'])->name('product_color.create.get');
                    Route::post('/create', [ProductColorCreateController::class, 'post', 'as' => 'product_color.create.post'])->name('product_color.create.post');
                    Route::get('/update/{id}', [ProductColorUpdateController::class, 'get', 'as' => 'product_color.update.get'])->name('product_color.update.get');
                    Route::post('/update/{id}', [ProductColorUpdateController::class, 'post', 'as' => 'product_color.update.post'])->name('product_color.update.post');
                    Route::get('/delete/{id}', [ProductColorDeleteController::class, 'get', 'as' => 'product_color.delete.get'])->name('product_color.delete.get');
                });
                Route::prefix('/price')->group(function () {
                    Route::get('/', [ProductPricePaginateController::class, 'get', 'as' => 'product_price.paginate.get'])->name('product_price.paginate.get');
                    Route::get('/create', [ProductPriceCreateController::class, 'get', 'as' => 'product_price.create.get'])->name('product_price.create.get');
                    Route::post('/create', [ProductPriceCreateController::class, 'post', 'as' => 'product_price.create.post'])->name('product_price.create.post');
                    Route::get('/update/{id}', [ProductPriceUpdateController::class, 'get', 'as' => 'product_price.update.get'])->name('product_price.update.get');
                    Route::post('/update/{id}', [ProductPriceUpdateController::class, 'post', 'as' => 'product_price.update.post'])->name('product_price.update.post');
                    Route::get('/delete/{id}', [ProductPriceDeleteController::class, 'get', 'as' => 'product_price.delete.get'])->name('product_price.delete.get');
                });
                Route::prefix('/image')->group(function () {
                    Route::get('/', [ProductImagePaginateController::class, 'get', 'as' => 'product_image.paginate.get'])->name('product_image.paginate.get');
                    Route::get('/create', [ProductImageCreateController::class, 'get', 'as' => 'product_image.create.get'])->name('product_image.create.get');
                    Route::post('/create', [ProductImageCreateController::class, 'post', 'as' => 'product_image.create.post'])->name('product_image.create.post');
                    Route::get('/update/{id}', [ProductImageUpdateController::class, 'get', 'as' => 'product_image.update.get'])->name('product_image.update.get');
                    Route::post('/update/{id}', [ProductImageUpdateController::class, 'post', 'as' => 'product_image.update.post'])->name('product_image.update.post');
                    Route::get('/delete/{id}', [ProductImageDeleteController::class, 'get', 'as' => 'product_image.delete.get'])->name('product_image.delete.get');
                });
            });
        });
    });

    Route::middleware(['role:Super-Admin'])->prefix('/cart-charges')->group(function () {
        Route::get('/', [ChargePaginateController::class, 'get', 'as' => 'charge.paginate.get'])->name('charge.paginate.get');
        Route::get('/create', [ChargeCreateController::class, 'get', 'as' => 'charge.create.get'])->name('charge.create.get');
        Route::post('/create', [ChargeCreateController::class, 'post', 'as' => 'charge.create.post'])->name('charge.create.post');
        Route::get('/update/{id}', [ChargeUpdateController::class, 'get', 'as' => 'charge.update.get'])->name('charge.update.get');
        Route::post('/update/{id}', [ChargeUpdateController::class, 'post', 'as' => 'charge.update.post'])->name('charge.update.post');
        Route::get('/delete/{id}', [ChargeDeleteController::class, 'get', 'as' => 'charge.delete.get'])->name('charge.delete.get');
    });

    Route::middleware(['role:Super-Admin'])->prefix('/delivery-slots')->group(function () {
        Route::get('/', [DeliverySlotPaginateController::class, 'get', 'as' => 'delivery_slot.paginate.get'])->name('delivery_slot.paginate.get');
        Route::get('/create', [DeliverySlotCreateController::class, 'get', 'as' => 'delivery_slot.create.get'])->name('delivery_slot.create.get');
        Route::post('/create', [DeliverySlotCreateController::class, 'post', 'as' => 'delivery_slot.create.post'])->name('delivery_slot.create.post');
        Route::get('/update/{id}', [DeliverySlotUpdateController::class, 'get', 'as' => 'delivery_slot.update.get'])->name('delivery_slot.update.get');
        Route::post('/update/{id}', [DeliverySlotUpdateController::class, 'post', 'as' => 'delivery_slot.update.post'])->name('delivery_slot.update.post');
        Route::get('/delete/{id}', [DeliverySlotDeleteController::class, 'get', 'as' => 'delivery_slot.delete.get'])->name('delivery_slot.delete.get');
    });

    Route::middleware(['role:Super-Admin|Staff|Inventory Manager'])->prefix('/order')->group(function () {
        Route::get('/', [OrderAdminPaginateController::class, 'get', 'as' => 'order_admin.paginate.get'])->name('order_admin.paginate.get');
        Route::get('/excel', [OrderAdminExcelController::class, 'get', 'as' => 'order_admin.excel.get'])->name('order_admin.excel.get');
        Route::get('/detail/{id}', [OrderAdminDetailController::class, 'get', 'as' => 'order_admin.detail.get'])->name('order_admin.detail.get');
        Route::get('/pdf/{id}', [OrderAdminInvoicePdfController::class, 'get', 'as' => 'order_admin.pdf.get'])->name('order_admin.pdf.get');
        Route::get('/update-status/{id}', [OrderAdminStatusController::class, 'get', 'as' => 'order_admin.update_order_status.get'])->name('order_admin.update_order_status.get');
        Route::get('/cancel/{id}', [OrderAdminCancelController::class, 'get', 'as' => 'order_admin.cancel.get'])->name('order_admin.cancel.get');
        Route::get('/payment-update/{id}', [OrderAdminCollectPaymentController::class, 'get', 'as' => 'order_admin.payment_update.get'])->name('order_admin.payment_update.get');
    });

    Route::middleware(['role:Super-Admin|Staff'])->prefix('/delivery-management')->group(function () {
        Route::get('/agent', [DeliveryAgentPaginateController::class, 'get', 'as' => 'delivery_management.agent.paginate.get'])->name('delivery_management.agent.paginate.get');
        Route::get('/agent/{user_id}/assign', [AssignDeliveryAgentController::class, 'get', 'as' => 'delivery_management.agent.assign_order.get'])->name('delivery_management.agent.assign_order.get');
        Route::post('/agent/{user_id}/assign', [AssignDeliveryAgentController::class, 'post', 'as' => 'delivery_management.agent.assign_order.post'])->name('delivery_management.agent.assign_order.post');
        Route::get('/agent/{user_id}/order-assigned', [AssignedOrderController::class, 'get', 'as' => 'delivery_management.agent.assigned_order.get'])->name('delivery_management.agent.assigned_order.get');
        Route::get('/agent/{user_id}/order-assigned/export', [AssignedOrderController::class, 'export', 'as' => 'delivery_management.agent.assigned_order.export'])->name('delivery_management.agent.assigned_order.export');
        Route::post('/agent/{user_id}/order-unassign', [AssignedOrderController::class, 'post', 'as' => 'delivery_management.agent.unassign_order.post'])->name('delivery_management.agent.unassign_order.post');
    });

    Route::middleware(['role:Delivery Agent'])->prefix('/delivery')->group(function () {
        Route::get('/order', [AssignedOrderForAgentPaginateController::class, 'get', 'as' => 'delivery_management.agent.order.get'])->name('delivery_management.agent.order.get');
        Route::get('/order/{order_id}', [AssignedOrderForAgentPaginateController::class, 'detail', 'as' => 'delivery_management.agent.order_detail.get'])->name('delivery_management.agent.order_detail.get');
        Route::get('/order/{order_id}/send-otp', [AssignedOrderForAgentPaginateController::class, 'send_otp', 'as' => 'delivery_management.agent.order_send_otp.get'])->middleware(['throttle:3,1'])->name('delivery_management.agent.order_send_otp.get');
        Route::post('/order/{order_id}/complete', [AssignedOrderForAgentPaginateController::class, 'deliver_order', 'as' => 'delivery_management.agent.order_deliver_order.post'])->name('delivery_management.agent.order_deliver_order.post');
        Route::get('/order/{order_id}/generate-qr-code', [AssignedOrderForAgentPaginateController::class, 'payUMoneyView', 'as' => 'delivery_management.agent.order_generate_qr_code.get'])->middleware(['throttle:3,1'])->name('delivery_management.agent.order_generate_qr_code.get');
    });

    Route::prefix('/promoter-management')->group(function () {
        Route::get('/agent', [PromoterPaginateController::class, 'get', 'as' => 'promoter.agent.paginate.get'])->name('promoter.agent.paginate.get')->middleware(['role:Super-Admin|Staff|Sales Coordinators']);
        Route::get('/agent/{user_id}/installer', [PromoterInstalledController::class, 'get', 'as' => 'promoter.agent.installer.get'])->name('promoter.agent.installer.get')->middleware(['role:Super-Admin|Staff|Sales Coordinators']);
        Route::get('/agent/{user_id}/installer/export', [PromoterInstalledController::class, 'export', 'as' => 'promoter.agent.installer.export'])->name('promoter.agent.installer.export')->middleware(['role:Super-Admin|Staff|Sales Coordinators']);
        Route::get('/agent/{user_id}/bank-information', [PromoterBankInformationController::class, 'get', 'as' => 'promoter.agent.installer_bank.get'])->name('promoter.agent.installer_bank.get')->middleware(['role:Super-Admin|Staff']);
        Route::post('/agent/{user_id}/bank-information', [PromoterBankInformationController::class, 'post', 'as' => 'promoter.agent.installer_bank.post'])->name('promoter.agent.installer_bank.post')->middleware(['role:Super-Admin|Staff']);
        Route::get('/agent/{agent_id}/installer/{user_id}', [PromoterInstalledController::class, 'destroy', 'as' => 'promoter.agent.installer.delete'])->name('promoter.agent.installer.delete')->middleware(['role:Super-Admin|Staff']);
        Route::get('/agent/{agent_id}/installer/{user_id}/toggle', [PromoterInstalledController::class, 'toggle', 'as' => 'promoter.agent.installer.toggle'])->name('promoter.agent.installer.toggle')->middleware(['role:Super-Admin|Staff|Sales Coordinators']);
    });

    Route::middleware(['role:App Promoter|Reward Riders|Referral Rockstars'])->prefix('/promoter')->group(function () {
        Route::get('/', [PromoterInstallerPaginateController::class, 'get', 'as' => 'promoter.agent.app_installer.get'])->name('promoter.agent.app_installer.get');
        Route::get('/bank-information', [PromoterSelfBankInformationController::class, 'get', 'as' => 'promoter.agent.bank_information.get'])->name('promoter.agent.bank_information.get');
        Route::post('/bank-information', [PromoterSelfBankInformationController::class, 'post', 'as' => 'promoter.agent.bank_information.post'])->name('promoter.agent.bank_information.post');
    });

    Route::middleware(['role:Warehouse Manager'])->prefix('/warehouse-management')->group(function () {
        Route::get('/order', [WarehouseOrderPaginateController::class, 'get', 'as' => 'warehouse_management.order.get'])->name('warehouse_management.order.get');
        Route::get('/order/{order_id}', [WarehouseOrderDetailController::class, 'get', 'as' => 'warehouse_management.order_detail.get'])->name('warehouse_management.order_detail.get');
        Route::get('/order/{order_id}/packed', [WarehouseOrderStatusUpdateController::class, 'get', 'as' => 'warehouse_management.order_placed.get'])->name('warehouse_management.order_placed.get');
    });

    Route::post('/text-editor-image', [TextEditorImageController::class, 'post', 'as' => 'texteditor_image.post'])->name('texteditor_image.post');
    Route::get('/logout', [LogoutController::class, 'get', 'as' => 'logout.get'])->name('logout.get');

});
