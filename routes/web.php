<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'show'])->name('home');
Route::get('/test', [\App\Http\Controllers\HomeController::class, 'test'])->name('test');
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'show'])->name('contact');
Route::post('contact/message', [\App\Http\Controllers\ContactController::class, 'sendMessage'])->name('contact.message.sent');
Route::get('/about', [\App\Http\Controllers\AboutController::class, 'show'])->name('about');
Route::get('/store/status', [\App\Http\Controllers\Admin\StoreStatusController::class, 'show'])->name('store.status');
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'show'])->name('cart');
Route::get('/services', [\App\Http\Controllers\ServiceController::class, 'index'])->name('services');
Route::get('/services/{id}', [\App\Http\Controllers\ServiceController::class, 'show'])->name('services.show');
Route::get('/order', [\App\Http\Controllers\OrderController::class, 'show'])->name('order');
Route::view('/privacy-policy', "privacy-policy.show")->name('privacy.show');
Route::view('/terms-and-conditions', "terms-and-conditions.show")->name('terms.show');


Route::post('/warranty/check', [\App\Http\Controllers\WarrantyCheckController::class, 'show'])->name('warranty.check');


if (App::environment('local')) {
    Route::view('/404', "errors.404");
    Route::view('/403', "errors.403");
    Route::view('/401', "errors.401");
    Route::view('/429', "errors.429");
    Route::view('/500', "errors.500");
    Route::view('/503', "errors.503");
    Route::get('/mail/test', function () {
        return new \App\Mail\TestMail();
    });
}


Route::group(['middleware' => ['guest']], function () {
    Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'show'])->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('login.attempt');
    Route::get('sign-up', [\App\Http\Controllers\Auth\SignUpController::class, 'show'])->name('sign-up');
    Route::post('sign-up', [\App\Http\Controllers\Auth\SignUpController::class, 'create'])->name('sign-up.submit');
    Route::get('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'show'])->name('forgot-password');
    Route::post('forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetEmailLink'])->name('forgot-password.send');
    Route::get('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.reset.submit');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');
    Route::post('review/post', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
    Route::post('reviews/{review}/edit', [\App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::delete('reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('password-change', [\App\Http\Controllers\PasswordController::class, 'show'])->name('password-change');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('user.profile');
    Route::put('user/password', [\App\Http\Controllers\PasswordController::class, 'update'])->name('user.password.update');
    Route::delete('/user/profile-photo', [\App\Http\Controllers\ProfilePhotoController::class, 'destroy'])->name('user.profile-photo.destroy');
    Route::put('/user/profile-information', [\App\Http\Controllers\ProfileController::class, 'update'])->name('user.profile-information.update');
    Route::delete('/user/account', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/orders', [\App\Http\Controllers\PurchaseHistoryController::class, 'index'])->name('user.orders.index');
    Route::get('/user/orders/{order}', [\App\Http\Controllers\PurchaseHistoryController::class, 'show'])->name('user.orders.show');
});


Route::get('/results', [\App\Http\Controllers\SearchController::class, 'show'])->name('search');
Route::get('/c/{id}', [\App\Http\Controllers\CategoryItemController::class, 'show'])->name('category.show');

Route::get('/sitemaps/sitemap_index.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemaps/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'show'])->name('sitemap.show');
Route::get('/sitemaps/sitemap-0.xml', [\App\Http\Controllers\SitemapController::class, 'sitemap0'])->name('sitemap.sitemap-0');
Route::get('/sitemaps/sitemap-1.xml', [\App\Http\Controllers\SitemapController::class, 'sitemap1'])->name('sitemap.sitemap-1');


Route::get('/uploads/{path}', [\App\Http\Controllers\ImageController::class, 'show'])->where('path', '.*')->name('image.show');
Route::get('/items/{id}/image', [\App\Http\Controllers\ItemImageController::class, 'show'])->name('item.image.show');
Route::get('/p/{id}', [\App\Http\Controllers\HomeController::class, 'showItem'])->name('item.show');


Route::prefix('admin')->name('admin.')->group(function () {

    Route::group(['middleware' => ['guest']], function () {
        Route::get('/', [\App\Http\Controllers\Admin\Auth\AdminLoginController::class, 'show'])->name('login');
        Route::post('login', [\App\Http\Controllers\Admin\Auth\AdminLoginController::class, 'authenticate'])->name('login.submit');
    });

    Route::group(['middleware' => ['auth', 'admin']], function () {
        Route::post('logout', [\App\Http\Controllers\Admin\Auth\AdminLogOutController::class, 'logout'])->name('logout');

        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'show'])->name('dashboard');

        Route::get('categories', [\App\Http\Controllers\Admin\Category\CategoryPageController::class, 'show'])->name('categories');
        Route::get('categories/parents/all', [\App\Http\Controllers\Admin\Category\CategoryController::class, 'index'])->name('categories.parents.index');
        Route::get('categories/all', [\App\Http\Controllers\Admin\Category\CategoryController::class, 'all'])->name('categories.index');
        Route::put('categories/status/{category}', [\App\Http\Controllers\Admin\Category\CategoryStatusController::class, 'update'])->name('categories.status.update');
        Route::post('categories', [\App\Http\Controllers\Admin\Category\CategoryController::class, 'store'])->name('categories.store');
        Route::put('categories/{category}', [\App\Http\Controllers\Admin\Category\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [\App\Http\Controllers\Admin\Category\CategoryController::class, 'destroy'])->name('categories.delete');
        Route::put('categories/{category}/parents/destroy', [\App\Http\Controllers\Admin\Category\CategoryController::class, 'destroyParent'])->name('categories.parents.destroy');




        Route::delete('categories/image/{category}', [\App\Http\Controllers\Admin\Category\CategoryImageController::class, 'destroy'])->name('categories.image.delete');
        Route::delete('categories/cover-image/{category}', [\App\Http\Controllers\Admin\Category\CategoryCoverImageController::class, 'destroy'])->name('categories.cover-image.delete');

        Route::get('payment_methods', [\App\Http\Controllers\Admin\PaymentMethod\PaymentMethodPageController::class, 'show'])->name('payment_methods');
        Route::get('payment_methods/all', [\App\Http\Controllers\Admin\PaymentMethod\PaymentMethodController::class, 'index'])->name('payment_methods.index');
        Route::put('payment_methods/status/{paymentMethod}', [\App\Http\Controllers\Admin\PaymentMethod\PaymentMethodStatusController::class, 'update'])->name('payment_methods.status.update');
        Route::post('payment_methods', [\App\Http\Controllers\Admin\PaymentMethod\PaymentMethodController::class, 'store'])->name('payment_methods.store');
        Route::put('payment_methods/{paymentMethod}', [\App\Http\Controllers\Admin\PaymentMethod\PaymentMethodController::class, 'update'])->name('payment_methods.update');
        Route::delete('payment_methods/{paymentMethod}', [\App\Http\Controllers\Admin\PaymentMethod\PaymentMethodController::class, 'destroy'])->name('payment_methods.delete');

        Route::get('areas', [\App\Http\Controllers\Admin\Area\AreaPageController::class, 'show'])->name('areas');
        Route::get('areas/all', [\App\Http\Controllers\Admin\Area\AreaController::class, 'index'])->name('areas.index');
        Route::put('areas/status/{area}', [\App\Http\Controllers\Admin\Area\AreaStatusController::class, 'update'])->name('areas.status.update');
        Route::post('areas', [\App\Http\Controllers\Admin\Area\AreaController::class, 'store'])->name('areas.store');
        Route::put('areas/{area}', [\App\Http\Controllers\Admin\Area\AreaController::class, 'update'])->name('areas.update');
        Route::delete('areas/{area}', [\App\Http\Controllers\Admin\Area\AreaController::class, 'destroy'])->name('areas.delete');

        Route::get('items', [\App\Http\Controllers\Admin\Item\ItemPageController::class, 'show'])->name('items');
        Route::get('items/all', [\App\Http\Controllers\Admin\Item\ItemController::class, 'index'])->name('items.index');
        Route::put('items/status/{item}', [\App\Http\Controllers\Admin\Item\ItemStatusController::class, 'update'])->name('items.status.update');
        Route::post('items', [\App\Http\Controllers\Admin\Item\ItemController::class, 'store'])->name('items.store');
        Route::put('items/{item}', [\App\Http\Controllers\Admin\Item\ItemController::class, 'update'])->name('items.update');
        Route::post('items/replicate/{item}', [\App\Http\Controllers\Admin\Item\ItemController::class, 'replicate'])->name('items.replicate');
        Route::delete('items/image/{item}', [\App\Http\Controllers\Admin\Item\ItemImageController::class, 'destroy'])->name('items.image.delete');
        Route::delete('items/additional-image/{image}', [\App\Http\Controllers\Admin\Item\ItemAdditionalImageController::class, 'destroy'])->name('items.additional-image.delete');
        Route::delete('items/{item}', [\App\Http\Controllers\Admin\Item\ItemController::class, 'destroy'])->name('items.delete');

        Route::get('serial-numbers', [\App\Http\Controllers\Admin\SerialNumberController::class, 'index'])->name('serial_numbers');
        Route::get('serial-numbers/create', [\App\Http\Controllers\Admin\SerialNumberController::class, 'create'])->name('serial_numbers.create');
        Route::post('serial-numbers', [\App\Http\Controllers\Admin\SerialNumberController::class, 'store'])->name('serial_numbers.store');
        Route::get('serial-numbers/{serial_number}', [\App\Http\Controllers\Admin\SerialNumberController::class, 'show'])->name('serial_numbers.show');
        Route::get('serial-numbers/{serial_number}/edit', [\App\Http\Controllers\Admin\SerialNumberController::class, 'edit'])->name('serial_numbers.edit');
        Route::put('serial-numbers/{serial_number}', [\App\Http\Controllers\Admin\SerialNumberController::class, 'update'])->name('serial_numbers.update');
        Route::delete('serial-numbers/{serial_number}', [\App\Http\Controllers\Admin\SerialNumberController::class, 'destroy'])->name('serial_numbers.destroy');








        Route::get('services', [\App\Http\Controllers\Admin\Service\ServicePageController::class, 'show'])->name('services');
        Route::get('services/all', [\App\Http\Controllers\Admin\Service\ServiceController::class, 'index'])->name('services.index');
        Route::put('services/status/{service}', [\App\Http\Controllers\Admin\Service\ServiceController::class, 'updateStatus'])->name('services.status.update');
        Route::post('services', [\App\Http\Controllers\Admin\Service\ServiceController::class, 'store'])->name('services.store');
        Route::put('services/{service}', [\App\Http\Controllers\Admin\Service\ServiceController::class, 'update'])->name('services.update');
        Route::delete('services/{service}', [\App\Http\Controllers\Admin\Service\ServiceController::class, 'destroy'])->name('services.delete');

        Route::get('bnrs', [\App\Http\Controllers\Admin\Banner\BannerPageController::class, 'show'])->name('banners');
        Route::get('bnrs/all', [\App\Http\Controllers\Admin\Banner\BannerController::class, 'index'])->name('banners.index');
        Route::put('bnrs/status/{banner}', [\App\Http\Controllers\Admin\Banner\BannerController::class, 'updateStatus'])->name('banners.status.update');
        Route::post('bnrs', [\App\Http\Controllers\Admin\Banner\BannerController::class, 'store'])->name('banners.store');
        Route::put('bnrs/{banner}', [\App\Http\Controllers\Admin\Banner\BannerController::class, 'update'])->name('banners.update');
        Route::delete('bnrs/{banner}', [\App\Http\Controllers\Admin\Banner\BannerController::class, 'destroy'])->name('banners.delete');

        Route::get('coupons', [\App\Http\Controllers\Admin\Coupon\CouponPageController::class, 'show'])->name('coupons');
        Route::get('coupons/all', [\App\Http\Controllers\Admin\Coupon\CouponController::class, 'index'])->name('coupons.index');
        Route::put('coupons/status/{coupon}', [\App\Http\Controllers\Admin\Coupon\CouponStatusController::class, 'update'])->name('coupons.status.update');
        Route::post('coupons', [\App\Http\Controllers\Admin\Coupon\CouponController::class, 'store'])->name('coupons.store');
        Route::put('coupons/{coupon}', [\App\Http\Controllers\Admin\Coupon\CouponController::class, 'update'])->name('coupons.update');
        Route::delete('coupons/{coupon}', [\App\Http\Controllers\Admin\Coupon\CouponController::class, 'destroy'])->name('coupons.delete');


        Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'show'])->name('settings');
        Route::get('settings/all', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings/{key}', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');

        Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications');
        Route::get('notifications/unread', [\App\Http\Controllers\Admin\NotificationController::class, 'unread'])->name('notifications.unread');
        Route::put('notifications/mark-as-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');

        Route::get('customers', [\App\Http\Controllers\Admin\Customer\CustomerController::class, 'index'])->name('customers');

        Route::get('/users', [\App\Http\Controllers\Admin\User\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\Admin\User\UserController::class, 'create'])->name('users.create');
        Route::post('/users/create', [\App\Http\Controllers\Admin\User\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\User\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}/edit', [\App\Http\Controllers\Admin\User\UserController::class, 'update'])->name('users.update');
        Route::get('/users/{user}/show', [\App\Http\Controllers\Admin\User\UserController::class, 'show'])->name('users.show');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\User\UserController::class, 'destroy'])->name('users.destroy');
        Route::delete('/user/{user}/profile-photo', [\App\Http\Controllers\Admin\User\UserController::class, 'destroyProfilePhoto'])->name('user.profile-photo.destroy');

        Route::get('/users/{user}/deposit', [\App\Http\Controllers\Admin\User\UserController::class, 'depositEdit'])->name('users.deposit.edit');
        Route::put('/users/{user}/deposit', [\App\Http\Controllers\Admin\User\UserController::class, 'depositUpdate'])->name('users.deposit.update');

        Route::get('orders', [\App\Http\Controllers\Admin\SubmittedOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}/status/{status}', [\App\Http\Controllers\Admin\OrderStatusController::class, 'update'])->name('orders.status.update');
        Route::get('orders/{order}/edit', [\App\Http\Controllers\Admin\SubmittedOrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}', [\App\Http\Controllers\Admin\SubmittedOrderController::class, 'update'])->name('orders.update');
        Route::delete('orders/{order}', [\App\Http\Controllers\Admin\SubmittedOrderController::class, 'destroy'])->name('orders.delete');
        Route::get('orders/{id}', [\App\Http\Controllers\Admin\SubmittedOrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{id}/print', [\App\Http\Controllers\Admin\SubmittedOrderController::class, 'print'])->name('orders.print');



        Route::get('/email/primary/test', [\App\Http\Controllers\Admin\TestEmailController::class, 'testPrimaryEmail'])->name('email.test');
    });
});
