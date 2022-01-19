<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\{ProfileController, CategoryController, FrontendController, VendorController, ProductController, WishlistController, CartController};
use Illuminate\Support\Facades\Auth;

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
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/name/change', [ProfileController::class, 'namechange'])->name('profile.namechange');
Route::post('/profile/password/change', [ProfileController::class, 'passwordchange'])->name('profile.passwordchange');
Route::post('/profile/photo/change', [ProfileController::class, 'photochange'])->name('profile.photochange');

Route::resource('category', CategoryController::class);
Route::resource('vendor', VendorController::class);
Route::resource('product', ProductController::class);
Route::resource('wishlist', WishlistController::class);
Route::get('/wishlist/insert/{product_id}', [WishlistController::class, 'insert'])->name('wishlist.insert');
Route::get('/wishlist/remove/{wishlist_id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/addtocartwish/{wishlist_id}', [CartController::class, 'addtocartwish'])->name('addtocartwish');
Route::post('/add/to/cart/{product_id}', [CartController::class, 'addtocart'])->name('addtocart');
Route::get('/cart/remove/{cart_id}', [CartController::class, 'cartremove'])->name('cartremove');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::get('/clear/shopping/cart/{user_id}', [CartController::class, 'clearshoppingcart'])->name('clearshoppingcart');

