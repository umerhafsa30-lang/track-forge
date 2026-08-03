<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\NewsletterAdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewAdminController;

// Public — customer submits review
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Admin — manage reviews (add ye apne existing admin middleware group ke andar)
Route::get('/admin/reviews', [ReviewAdminController::class, 'index'])->name('admin.reviews.index');
Route::patch('/admin/reviews/{review}/approve', [ReviewAdminController::class, 'approve'])->name('admin.reviews.approve');
Route::delete('/admin/reviews/{review}', [ReviewAdminController::class, 'destroy'])->name('admin.reviews.destroy');
Route::get('/admin/newsletter', [NewsletterAdminController::class, 'index'])->name('admin.newsletter.index');
Route::delete('/admin/newsletter/{subscriber}', [NewsletterAdminController::class, 'destroy'])->name('admin.newsletter.destroy');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::resource('admin/brands', BrandController::class);

// ---- Storefront ----
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Checkout coupon routes — public hai, customer login ke bina checkout karta hai
Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');

// ---- Admin auth ----
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // ---- Protected admin panel ----
    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('/products/generate-description', [AdminProductController::class, 'generateDescription'])
            ->name('products.generate-description');

        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('coupons', AdminCouponController::class);

        Route::post('/products/{product}/images', [AdminProductController::class, 'uploadImages'])
            ->name('products.images.upload');
        Route::delete('/products/images/{image}', [AdminProductController::class, 'deleteImage'])
            ->name('products.images.delete');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});