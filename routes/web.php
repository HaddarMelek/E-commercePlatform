<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\DashboardController;
use App\Http\Controllers\Auth\BuyerController;
use App\Http\Controllers\Auth\SellerController;
use App\Http\Controllers\Auth\CategoryController;
use App\Http\Controllers\Auth\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\CartController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\CheckoutController;
use App\Http\Controllers\Auth\OrderController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminOrderController;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pass', function () {
    return view('home');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');
require __DIR__.'/auth.php';

Route::get('/', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/buyer/index', [BuyerController::class, 'index'])
    ->middleware('auth')
    ->name('buyer.index');
    Route::get('/buyer/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
    Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('buyer.removeFromCart');
    Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('buyer.checkout');
    Route::post('/place-order/{id}', [CheckoutController::class, 'placeOrderBuyNow'])->name('buyer.placeOrder');


    Route::post('/checkoutValidate', [CheckoutController::class, 'placeOrder'])->name('buyer.proceedToCheckout');



    Route::get('/buyer/orders', [BuyerController::class, 'orders'])->name('buyer.orders');

    Route::get('/order/{userId}', [OrderController::class, 'showOrder'])->name('buyer.showOrder');
//buyer
Route::get('/seller/dashboard', [SellerController::class, 'index'])
    ->name('seller.dashboard');

    Route::get('products/create', [ProductController::class, 'createForm'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    
    Route::get('products/search-product', [ProductController::class, 'searchProduct'])->name('products.searchProduct');
    Route::get('products/edit-product/{id}', [ProductController::class, 'editProduct'])->name('products.editProduct');

    Route::put('products/update-product/{id}', [ProductController::class, 'updateProduct'])->name('products.updateProduct');    
    Route::delete('/products/delete-product/{id}', [ProductController::class, 'destroy'])->name('products.deleteProduct');
    Route::get('/products/{id}', [ProductController::class, 'showProduct'])->name('products.show');
    
Route::post('seller/update-order/{id}', [SellerController::class, 'updateOrder'])->name('seller.updateOrder');
Route::post('seller/cancel-order/{id}', [SellerController::class, 'cancelOrder'])->name('seller.cancelOrder');
Route::get('seller/order-details/{id}', [SellerController::class, 'showOrderDetails'])->name('seller.showOrderDetails');

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::post('/products/{id}/add-to-cart', [CartController::class, 'addToCart'])->name('products.addToCart');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::put('/user/profile/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');

Route::get('/user/profile/show', [UserController::class, 'showProfile'])->name('user.showProfile');

Route::delete('/user/profile/delete', [UserController::class, 'deleteProfile'])->name('user.deleteProfile');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

Route::get('/categories/index', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');


Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('order.edit');
Route::put('/orders/{order}/update', [OrderController::class, 'update'])->name('order.update');

Route::patch('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
//when adding admin function 
Route::get('/orders', [OrderController::class, 'index'])->name('seller.orders');

Route::get('seller/showOrders', [SellerController::class, 'showOrders'])->name('seller.showOrders');
Route::patch('/orders/update-details/{id}', [OrderController::class, 'updateDetails'])->name('orders.updateDetails');
Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/admin/discounts', [AdminDiscountController::class, 'index'])->name('admin.discounts');
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');


Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');

Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::post('/admin/orders/manage/{order}', [AdminOrderController::class, 'manageOrder'])->name('admin.orders.manage');
Route::delete('/admin/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
Route::get('/admin/discounts', [AdminOrderController::class, 'showDiscounts'])->name('admin.discounts');
Route::get('/seller/order-products/{orderId}', [SellerController::class, 'viewOrderProducts'])->name('seller.viewOrderProducts');
Route::post('/seller/confirm-order/{orderId}', [SellerController::class, 'confirmOrder'])->name('seller.confirmOrder');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/view/contact', [ContactController::class, 'viewMessages'])->name('view.contact');
Route::post('/orders/change-status/{id}', [OrderController::class, 'changeStatus'])->name('admin.orders.changeStatus');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.deleteProduct');
