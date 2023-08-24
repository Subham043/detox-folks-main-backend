<?php

use App\Modules\AboutPage\Main\Controllers\AboutMainController;
use App\Modules\Authentication\Controllers\PasswordUpdateController;
use App\Modules\Authentication\Controllers\ForgotPasswordController;
use App\Modules\Authentication\Controllers\LoginController;
use App\Modules\Authentication\Controllers\LogoutController;
use App\Modules\Authentication\Controllers\ProfileController;
use App\Modules\Authentication\Controllers\ResetPasswordController;
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
use App\Modules\Category\Controllers\CategoryPaginateController;
use App\Modules\Category\Controllers\CategoryUpdateController;
use App\Modules\Charge\Controllers\ChargeCreateController;
use App\Modules\Charge\Controllers\ChargeDeleteController;
use App\Modules\Charge\Controllers\ChargePaginateController;
use App\Modules\Charge\Controllers\ChargeUpdateController;
use App\Modules\Counter\Controllers\CounterCreateController;
use App\Modules\Counter\Controllers\CounterDeleteController;
use App\Modules\Counter\Controllers\CounterPaginateController;
use App\Modules\Counter\Controllers\CounterUpdateController;
use App\Modules\Coupon\Controllers\CouponCreateController;
use App\Modules\Coupon\Controllers\CouponDeleteController;
use App\Modules\Coupon\Controllers\CouponPaginateController;
use App\Modules\Coupon\Controllers\CouponUpdateController;
use App\Modules\Feature\Controllers\FeatureCreateController;
use App\Modules\Feature\Controllers\FeatureDeleteController;
use App\Modules\Feature\Controllers\FeaturePaginateController;
use App\Modules\Feature\Controllers\FeatureUpdateController;
use App\Modules\Partner\Controllers\PartnerCreateController;
use App\Modules\Partner\Controllers\PartnerDeleteController;
use App\Modules\Partner\Controllers\PartnerPaginateController;
use App\Modules\Partner\Controllers\PartnerUpdateController;
use App\Modules\Role\Controllers\RoleCreateController;
use App\Modules\Role\Controllers\RoleDeleteController;
use App\Modules\Role\Controllers\RolePaginateController;
use App\Modules\Role\Controllers\RoleUpdateController;
use App\Modules\Settings\Controllers\ActivityLog\ActivityLogDetailController;
use App\Modules\Settings\Controllers\ActivityLog\ActivityLogPaginateController;
use App\Modules\Settings\Controllers\ErrorLogController;
use App\Modules\Settings\Controllers\General\GeneralController;
use App\Modules\Settings\Controllers\SitemapController;
use App\Modules\User\Controllers\UserCreateController;
use App\Modules\User\Controllers\UserDeleteController;
use App\Modules\User\Controllers\UserPaginateController;
use App\Modules\User\Controllers\UserUpdateController;
use App\Modules\Testimonial\Controllers\TestimonialCreateController;
use App\Modules\Testimonial\Controllers\TestimonialDeleteController;
use App\Modules\Testimonial\Controllers\TestimonialPaginateController;
use App\Modules\Testimonial\Controllers\TestimonialUpdateController;
use App\Modules\HomePage\Banner\Controllers\BannerCreateController;
use App\Modules\HomePage\Banner\Controllers\BannerDeleteController;
use App\Modules\HomePage\Banner\Controllers\BannerPaginateController;
use App\Modules\HomePage\Banner\Controllers\BannerUpdateController;
use App\Modules\Product\Controllers\ProductCreateController;
use App\Modules\Product\Controllers\ProductDeleteController;
use App\Modules\Product\Controllers\ProductPaginateController;
use App\Modules\Product\Controllers\ProductUpdateController;
use App\Modules\ProductImage\Controllers\ProductImageCreateController;
use App\Modules\ProductImage\Controllers\ProductImageDeleteController;
use App\Modules\ProductImage\Controllers\ProductImagePaginateController;
use App\Modules\ProductImage\Controllers\ProductImageUpdateController;
use App\Modules\ProductPrice\Controllers\ProductPriceCreateController;
use App\Modules\ProductPrice\Controllers\ProductPriceDeleteController;
use App\Modules\ProductPrice\Controllers\ProductPricePaginateController;
use App\Modules\ProductPrice\Controllers\ProductPriceUpdateController;
use App\Modules\ProductSpecification\Controllers\ProductSpecificationCreateController;
use App\Modules\ProductSpecification\Controllers\ProductSpecificationDeleteController;
use App\Modules\ProductSpecification\Controllers\ProductSpecificationPaginateController;
use App\Modules\ProductSpecification\Controllers\ProductSpecificationUpdateController;
use App\Modules\Seo\Controllers\SeoPaginateController;
use App\Modules\Seo\Controllers\SeoUpdateController;
use App\Modules\SubCategory\Controllers\SubCategoryCreateController;
use App\Modules\SubCategory\Controllers\SubCategoryDeleteController;
use App\Modules\SubCategory\Controllers\SubCategoryPaginateController;
use App\Modules\SubCategory\Controllers\SubCategoryUpdateController;
use App\Modules\Tax\Controllers\TaxController;
use App\Modules\TextEditorImage\Controllers\TextEditorImageController;
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
    Route::get('/login', [LoginController::class, 'get', 'as' => 'login.get'])->name('login.get');
    Route::post('/authenticate', [LoginController::class, 'post', 'as' => 'login.post'])->name('login.post');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'get', 'as' => 'forgot_password.get'])->name('forgot_password.get');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'post', 'as' => 'forgot_password.post'])->name('forgot_password.post');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'get', 'as' => 'reset_password.get'])->name('reset_password.get')->middleware('signed');
    Route::post('/reset-password/{token}', [ResetPasswordController::class, 'post', 'as' => 'reset_password.post'])->name('reset_password.post')->middleware('signed');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'get', 'as' => 'dashboard.get'])->name('dashboard.get');

    Route::prefix('/setting')->group(function () {
        Route::get('/general', [GeneralController::class, 'get', 'as' => 'general.settings.get'])->name('general.settings.get');
        Route::post('/general-post', [GeneralController::class, 'post', 'as' => 'general.settings.post'])->name('general.settings.post');
        Route::get('/sitemap', [SitemapController::class, 'get', 'as' => 'sitemap.get'])->name('sitemap.get');
        Route::get('/sitemap-generate', [SitemapController::class, 'generate', 'as' => 'sitemap.generate'])->name('sitemap.generate');
    });

    Route::prefix('/logs')->group(function () {
        Route::get('/error', [ErrorLogController::class, 'get', 'as' => 'error_log.get'])->name('error_log.get');
        Route::prefix('/activity')->group(function () {
            Route::get('/', [ActivityLogPaginateController::class, 'get', 'as' => 'activity_log.paginate.get'])->name('activity_log.paginate.get');
            Route::get('/{id}', [ActivityLogDetailController::class, 'get', 'as' => 'activity_log.detail.get'])->name('activity_log.detail.get');

        });
    });

    Route::prefix('/enquiry')->group(function () {
        Route::prefix('/contact-form')->group(function () {
            Route::get('/', [ContactFormPaginateController::class, 'get', 'as' => 'enquiry.contact_form.paginate.get'])->name('enquiry.contact_form.paginate.get');
            Route::get('/excel', [ContactFormExcelController::class, 'get', 'as' => 'enquiry.contact_form.excel.get'])->name('enquiry.contact_form.excel.get');
            Route::get('/delete/{id}', [ContactFormDeleteController::class, 'get', 'as' => 'enquiry.contact_form.delete.get'])->name('enquiry.contact_form.delete.get');

        });
    });

    Route::prefix('/legal-pages')->group(function () {
        Route::get('/', [LegalPaginateController::class, 'get', 'as' => 'legal.paginate.get'])->name('legal.paginate.get');
        Route::get('/update/{slug}', [LegalUpdateController::class, 'get', 'as' => 'legal.update.get'])->name('legal.update.get');
        Route::post('/update/{slug}', [LegalUpdateController::class, 'post', 'as' => 'legal.update.post'])->name('legal.update.post');
    });

    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'get', 'as' => 'profile.get'])->name('profile.get');
        Route::post('/update', [ProfileController::class, 'post', 'as' => 'profile.post'])->name('profile.post');
        Route::post('/profile-password-update', [PasswordUpdateController::class, 'post', 'as' => 'password.post'])->name('password.post');
    });

    Route::prefix('/role')->group(function () {
        Route::get('/', [RolePaginateController::class, 'get', 'as' => 'role.paginate.get'])->name('role.paginate.get');
        Route::get('/create', [RoleCreateController::class, 'get', 'as' => 'role.create.get'])->name('role.create.get');
        Route::post('/create', [RoleCreateController::class, 'post', 'as' => 'role.create.get'])->name('role.create.post');
        Route::get('/update/{id}', [RoleUpdateController::class, 'get', 'as' => 'role.update.get'])->name('role.update.get');
        Route::post('/update/{id}', [RoleUpdateController::class, 'post', 'as' => 'role.update.get'])->name('role.update.post');
        Route::get('/delete/{id}', [RoleDeleteController::class, 'get', 'as' => 'role.delete.get'])->name('role.delete.get');
    });

    Route::prefix('/user')->group(function () {
        Route::get('/', [UserPaginateController::class, 'get', 'as' => 'user.paginate.get'])->name('user.paginate.get');
        Route::get('/create', [UserCreateController::class, 'get', 'as' => 'user.create.get'])->name('user.create.get');
        Route::post('/create', [UserCreateController::class, 'post', 'as' => 'user.create.get'])->name('user.create.post');
        Route::get('/update/{id}', [UserUpdateController::class, 'get', 'as' => 'user.update.get'])->name('user.update.get');
        Route::post('/update/{id}', [UserUpdateController::class, 'post', 'as' => 'user.update.get'])->name('user.update.post');
        Route::get('/delete/{id}', [UserDeleteController::class, 'get', 'as' => 'user.delete.get'])->name('user.delete.get');
    });

    Route::prefix('/blog')->group(function () {
        Route::get('/', [BlogPaginateController::class, 'get', 'as' => 'blog.paginate.get'])->name('blog.paginate.get');
        Route::get('/create', [BlogCreateController::class, 'get', 'as' => 'blog.create.get'])->name('blog.create.get');
        Route::post('/create', [BlogCreateController::class, 'post', 'as' => 'blog.create.post'])->name('blog.create.post');
        Route::get('/update/{id}', [BlogUpdateController::class, 'get', 'as' => 'blog.update.get'])->name('blog.update.get');
        Route::post('/update/{id}', [BlogUpdateController::class, 'post', 'as' => 'blog.update.post'])->name('blog.update.post');
        Route::get('/delete/{id}', [BlogDeleteController::class, 'get', 'as' => 'blog.delete.get'])->name('blog.delete.get');
    });

    Route::prefix('/partner')->group(function () {
        Route::get('/', [PartnerPaginateController::class, 'get', 'as' => 'partner.paginate.get'])->name('partner.paginate.get');
        Route::get('/create', [PartnerCreateController::class, 'get', 'as' => 'partner.create.get'])->name('partner.create.get');
        Route::post('/create', [PartnerCreateController::class, 'post', 'as' => 'partner.create.post'])->name('partner.create.post');
        Route::get('/update/{id}', [PartnerUpdateController::class, 'get', 'as' => 'partner.update.get'])->name('partner.update.get');
        Route::post('/update/{id}', [PartnerUpdateController::class, 'post', 'as' => 'partner.update.post'])->name('partner.update.post');
        Route::get('/delete/{id}', [PartnerDeleteController::class, 'get', 'as' => 'partner.delete.get'])->name('partner.delete.get');

    });

    Route::prefix('/counter')->group(function () {
        Route::get('/', [CounterPaginateController::class, 'get', 'as' => 'counter.paginate.get'])->name('counter.paginate.get');
        Route::get('/create', [CounterCreateController::class, 'get', 'as' => 'counter.create.get'])->name('counter.create.get');
        Route::post('/create', [CounterCreateController::class, 'post', 'as' => 'counter.create.post'])->name('counter.create.post');
        Route::get('/update/{id}', [CounterUpdateController::class, 'get', 'as' => 'counter.update.get'])->name('counter.update.get');
        Route::post('/update/{id}', [CounterUpdateController::class, 'post', 'as' => 'counter.update.post'])->name('counter.update.post');
        Route::get('/delete/{id}', [CounterDeleteController::class, 'get', 'as' => 'counter.delete.get'])->name('counter.delete.get');

    });

    Route::prefix('/testimonial')->group(function () {
        Route::get('/', [TestimonialPaginateController::class, 'get', 'as' => 'testimonial.paginate.get'])->name('testimonial.paginate.get');
        Route::get('/create', [TestimonialCreateController::class, 'get', 'as' => 'testimonial.create.get'])->name('testimonial.create.get');
        Route::post('/create', [TestimonialCreateController::class, 'post', 'as' => 'testimonial.create.post'])->name('testimonial.create.post');
        Route::get('/update/{id}', [TestimonialUpdateController::class, 'get', 'as' => 'testimonial.update.get'])->name('testimonial.update.get');
        Route::post('/update/{id}', [TestimonialUpdateController::class, 'post', 'as' => 'testimonial.update.post'])->name('testimonial.update.post');
        Route::get('/delete/{id}', [TestimonialDeleteController::class, 'get', 'as' => 'testimonial.delete.get'])->name('testimonial.delete.get');
    });

    Route::prefix('/home-page')->group(function () {
        Route::prefix('/banner')->group(function () {
            Route::get('/', [BannerPaginateController::class, 'get', 'as' => 'home_page.banner.paginate.get'])->name('home_page.banner.paginate.get');
            Route::get('/create', [BannerCreateController::class, 'get', 'as' => 'home_page.banner.create.get'])->name('home_page.banner.create.get');
            Route::post('/create', [BannerCreateController::class, 'post', 'as' => 'home_page.banner.create.post'])->name('home_page.banner.create.post');
            Route::get('/update/{id}', [BannerUpdateController::class, 'get', 'as' => 'home_page.banner.update.get'])->name('home_page.banner.update.get');
            Route::post('/update/{id}', [BannerUpdateController::class, 'post', 'as' => 'home_page.banner.update.post'])->name('home_page.banner.update.post');
            Route::get('/delete/{id}', [BannerDeleteController::class, 'get', 'as' => 'home_page.banner.delete.get'])->name('home_page.banner.delete.get');

        });

    });

    Route::prefix('/category')->group(function () {
        Route::get('/', [CategoryPaginateController::class, 'get', 'as' => 'category.paginate.get'])->name('category.paginate.get');
        Route::get('/create', [CategoryCreateController::class, 'get', 'as' => 'category.create.get'])->name('category.create.get');
        Route::post('/create', [CategoryCreateController::class, 'post', 'as' => 'category.create.post'])->name('category.create.post');
        Route::get('/update/{id}', [CategoryUpdateController::class, 'get', 'as' => 'category.update.get'])->name('category.update.get');
        Route::post('/update/{id}', [CategoryUpdateController::class, 'post', 'as' => 'category.update.post'])->name('category.update.post');
        Route::get('/delete/{id}', [CategoryDeleteController::class, 'get', 'as' => 'category.delete.get'])->name('category.delete.get');
        Route::post('/api', [CategoryApiController::class, 'post', 'as' => 'category.api.post'])->name('category.api.post');
    });

    Route::prefix('/sub-category')->group(function () {
        Route::get('/', [SubCategoryPaginateController::class, 'get', 'as' => 'sub_category.paginate.get'])->name('sub_category.paginate.get');
        Route::get('/create', [SubCategoryCreateController::class, 'get', 'as' => 'sub_category.create.get'])->name('sub_category.create.get');
        Route::post('/create', [SubCategoryCreateController::class, 'post', 'as' => 'sub_category.create.post'])->name('sub_category.create.post');
        Route::get('/update/{id}', [SubCategoryUpdateController::class, 'get', 'as' => 'sub_category.update.get'])->name('sub_category.update.get');
        Route::post('/update/{id}', [SubCategoryUpdateController::class, 'post', 'as' => 'sub_category.update.post'])->name('sub_category.update.post');
        Route::get('/delete/{id}', [SubCategoryDeleteController::class, 'get', 'as' => 'sub_category.delete.get'])->name('sub_category.delete.get');
    });

    Route::prefix('/coupon')->group(function () {
        Route::get('/', [CouponPaginateController::class, 'get', 'as' => 'coupon.paginate.get'])->name('coupon.paginate.get');
        Route::get('/create', [CouponCreateController::class, 'get', 'as' => 'coupon.create.get'])->name('coupon.create.get');
        Route::post('/create', [CouponCreateController::class, 'post', 'as' => 'coupon.create.post'])->name('coupon.create.post');
        Route::get('/update/{id}', [CouponUpdateController::class, 'get', 'as' => 'coupon.update.get'])->name('coupon.update.get');
        Route::post('/update/{id}', [CouponUpdateController::class, 'post', 'as' => 'coupon.update.post'])->name('coupon.update.post');
        Route::get('/delete/{id}', [CouponDeleteController::class, 'get', 'as' => 'coupon.delete.get'])->name('coupon.delete.get');
    });

    Route::prefix('/product')->group(function () {
        Route::get('/', [ProductPaginateController::class, 'get', 'as' => 'product.paginate.get'])->name('product.paginate.get');
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

    Route::prefix('/about-page')->group(function () {
        Route::get('/main', [AboutMainController::class, 'get', 'as' => 'about.main.get'])->name('about.main.get');
        Route::post('/main', [AboutMainController::class, 'post', 'as' => 'about.main.post'])->name('about.main.post');
    });

    Route::prefix('/tax')->group(function () {
        Route::get('/', [TaxController::class, 'get', 'as' => 'tax.get'])->name('tax.get');
        Route::post('/', [TaxController::class, 'post', 'as' => 'tax.post'])->name('tax.post');
    });

    Route::prefix('/feature')->group(function () {
        Route::get('/', [FeaturePaginateController::class, 'get', 'as' => 'feature.paginate.get'])->name('feature.paginate.get');
        Route::get('/create', [FeatureCreateController::class, 'get', 'as' => 'feature.create.get'])->name('feature.create.get');
        Route::post('/create', [FeatureCreateController::class, 'post', 'as' => 'feature.create.post'])->name('feature.create.post');
        Route::get('/update/{id}', [FeatureUpdateController::class, 'get', 'as' => 'feature.update.get'])->name('feature.update.get');
        Route::post('/update/{id}', [FeatureUpdateController::class, 'post', 'as' => 'feature.update.post'])->name('feature.update.post');
        Route::get('/delete/{id}', [FeatureDeleteController::class, 'get', 'as' => 'feature.delete.get'])->name('feature.delete.get');
    });

    Route::prefix('/other-charges')->group(function () {
        Route::get('/', [ChargePaginateController::class, 'get', 'as' => 'charge.paginate.get'])->name('charge.paginate.get');
        Route::get('/create', [ChargeCreateController::class, 'get', 'as' => 'charge.create.get'])->name('charge.create.get');
        Route::post('/create', [ChargeCreateController::class, 'post', 'as' => 'charge.create.post'])->name('charge.create.post');
        Route::get('/update/{id}', [ChargeUpdateController::class, 'get', 'as' => 'charge.update.get'])->name('charge.update.get');
        Route::post('/update/{id}', [ChargeUpdateController::class, 'post', 'as' => 'charge.update.post'])->name('charge.update.post');
        Route::get('/delete/{id}', [ChargeDeleteController::class, 'get', 'as' => 'charge.delete.get'])->name('charge.delete.get');
    });

    Route::prefix('/seo')->group(function () {
        Route::get('/', [SeoPaginateController::class, 'get', 'as' => 'seo.paginate.get'])->name('seo.paginate.get');
        Route::get('/update/{slug}', [SeoUpdateController::class, 'get', 'as' => 'seo.update.get'])->name('seo.update.get');
        Route::post('/update/{slug}', [SeoUpdateController::class, 'post', 'as' => 'seo.update.post'])->name('seo.update.post');
    });

    Route::post('/text-editor-image', [TextEditorImageController::class, 'post', 'as' => 'texteditor_image.post'])->name('texteditor_image.post');
    Route::get('/logout', [LogoutController::class, 'get', 'as' => 'logout.get'])->name('logout.get');

});
