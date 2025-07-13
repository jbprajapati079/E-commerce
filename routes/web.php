<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
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

Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('wishlist/add', [WishlistController::class, 'addWishList'])->name('wishlist.add');

Route::put('/wishlist/qty-increase/{rowId}', [WishlistController::class, 'qty_increase'])->name('wishlist.qty_increase');
Route::put('/wishlist/qty-reduce/{rowId}', [WishlistController::class, 'qty_reduce'])->name('wishlist.qty_reduce');

Route::delete('/wishlist/remove/{rowId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');


Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //Brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brand/add', [BrandController::class, 'create'])->name('brand.add');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brand/edit/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::put('/brand/update/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('/brand/delete/{id}', [BrandController::class, 'delete'])->name('brand.delete');

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
});


require __DIR__ . '/auth.php';
