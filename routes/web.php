<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\{CheckoutController, ProfileController, CategoryController, FrontendController, VendorController, ProductController, WishlistController, CartController, CouponController};
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SslCommerzPaymentController;

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

Auth::routes();

Route::get('/', [FrontendController::class, 'index'])->name('frontend');

Route::get('product/details/{slug}', [FrontendController::class, 'productdetails'])->name('productdetails');
Route::get('categorywise/{category_id}', [FrontendController::class, 'categorywiseproducts'])->name('categorywiseproducts');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/email/offer', [HomeController::class, 'emailoffer'])->name('emailoffer');
Route::get('/single/email/offer/{id}', [HomeController::class, 'singleemailoffer'])->name('singeemailoffer');
Route::post('/check/email/offer', [HomeController::class, 'checkemailoffer'])->name('checkemailoffer');
Route::get('/location', [HomeController::class, 'location'])->name('location');
Route::post('/location/update', [HomeController::class, 'location_update'])->name('location.update');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/name/change', [ProfileController::class, 'namechange'])->name('profile.namechange');
Route::post('/profile/password/change', [ProfileController::class, 'passwordchange'])->name('profile.passwordchange');
Route::post('/profile/photo/change', [ProfileController::class, 'photochange'])->name('profile.photochange');

Route::resource('category', CategoryController::class);
Route::resource('vendor', VendorController::class);
Route::resource('product', ProductController::class);
Route::resource('wishlist', WishlistController::class);
Route::resource('coupon', CouponController::class);
Route::get('/wishlist/insert/{product_id}', [WishlistController::class, 'insert'])->name('wishlist.insert');
Route::get('/wishlist/remove/{wishlist_id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/addtocartwish/{wishlist_id}', [CartController::class, 'addtocartwish'])->name('addtocartwish');
Route::post('/add/to/cart/{product_id}', [CartController::class, 'addtocart'])->name('addtocart');
Route::get('/cart/remove/{cart_id}', [CartController::class, 'cartremove'])->name('cartremove');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::get('/clear/shopping/cart/{user_id}', [CartController::class, 'clearshoppingcart'])->name('clearshoppingcart');
Route::post('/cart/update', [CartController::class, 'cartupdate'])->name('cartupdate');
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'checkout_post'])->name('checkout_post');
Route::post('/get/city/list', [CheckoutController::class, 'get_city_list'])->name('get_city_list');


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
