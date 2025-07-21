<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Role;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('search', [HomeController::class, 'search'])->name('home.search');


Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.update');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug_id}', [ShopController::class, 'product_details'])->name('shop.product_detail');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/qty-increase/{rowId}', [CartController::class, 'qty_increase'])->name('cart.qty_increase');

Route::put('/cart/qty-reduce/{rowId}', [CartController::class, 'qty_reduce'])->name('cart.qty_reduce');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/apply-coupon', [CartController::class, 'apply'])->name('apply.coupon');
Route::post('/remove-coupon', function () {
    session()->forget('applied_coupon');
    return redirect()->back()->with('coupon_message', 'Coupon removed successfully.');
})->name('remove.coupon');

Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('cart/order_place', [CartController::class, 'order_place'])->name('cart.order_place');
Route::get('cart/orderconfirm', [CartController::class, 'order_confirm'])->name('cart.order_confirm');

Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('wishlist/add', [WishlistController::class, 'addWishList'])->name('wishlist.add');

Route::put('/wishlist/qty-increase/{rowId}', [WishlistController::class, 'qty_increase'])->name('wishlist.qty_increase');
Route::put('/wishlist/qty-reduce/{rowId}', [WishlistController::class, 'qty_reduce'])->name('wishlist.qty_reduce');

Route::delete('/wishlist/remove/{rowId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');


Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('user/order', [UserController::class, 'order'])->name('user.order.list');
    Route::get('user/order/view/{id}', [UserController::class, 'view'])->name('user.order.view');
    Route::post('/user/order/cancel/{id}', [UserController::class, 'cancelOrder'])->name('user.order.cancel');

    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact-store', [ContactController::class, 'store'])->name('contact.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/profiles', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/admin/profile/update/{id}', [AdminController::class, 'profile_update'])->name('admin.profile.update');

    //Brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brand/add', [BrandController::class, 'create'])->name('brand.add');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('/brand/update/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('/brand/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');

     //Sizes
     Route::get('/size', [SizeController::class, 'index'])->name('size.index');
     Route::get('/size/add', [SizeController::class, 'create'])->name('size.add');
     Route::post('/size/store', [SizeController::class, 'store'])->name('size.store');
     Route::get('/size/edit/{id}', [SizeController::class, 'edit'])->name('size.edit');
     Route::put('/size/update/{id}', [SizeController::class, 'update'])->name('size.update');
     Route::delete('/size/delete/{id}', [SizeController::class, 'delete'])->name('size.delete');

    //Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/add', [CategoryController::class, 'create'])->name('category.add');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    //Product
    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/add', [ProductController::class, 'create'])->name('product.add');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

    //Coupon
    Route::get('/coupon', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('/coupon/add', [CouponController::class, 'create'])->name('coupon.add');
    Route::post('/coupon/store', [CouponController::class, 'store'])->name('coupon.store');
    Route::get('/coupon/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::put('/coupon/update/{id}', [CouponController::class, 'update'])->name('coupon.update');
    Route::delete('/coupon/delete/{id}', [CouponController::class, 'delete'])->name('coupon.delete');


    //Order
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/view/{id}', [OrderController::class, 'view'])->name('order.view');
    Route::post('/order/update-status/{id}', [OrderController::class, 'updateStatus'])->name('order.updateStatus');

    //Slide
    Route::get('/slide', [SlideController::class, 'index'])->name('slide.index');
    Route::get('/slide/add', [SlideController::class, 'create'])->name('slide.add');
    Route::post('/slide/store', [SlideController::class, 'store'])->name('slide.store');
    Route::get('/slide/edit/{id}', [SlideController::class, 'edit'])->name('slide.edit');
    Route::put('/slide/update/{id}', [SlideController::class, 'update'])->name('slide.update');
    Route::delete('/slide/delete/{id}', [SlideController::class, 'delete'])->name('slide.delete');

    Route::get('contact', [AdminContactController::class, 'index'])->name('contact.index');
    Route::delete('/contact/delete/{id}', [AdminContactController::class, 'delete'])->name('contact.delete');
});


require __DIR__ . '/auth.php';
