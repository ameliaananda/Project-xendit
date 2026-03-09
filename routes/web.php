<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\XenditWebhookController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| WEBHOOK XENDIT (TIDAK PAKAI AUTH)
|--------------------------------------------------------------------------
*/
Route::post('/xendit/webhook', [XenditWebhookController::class, 'handle'])
    ->name('xendit.webhook');


/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| CUSTOMER (HARUS LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return redirect('/shop');
    })->name('dashboard');


    // ===============================
    // SHOP
    // ===============================
    Route::get('/shop', [ProductController::class, 'shop'])
        ->name('shop');

    // BELI SEKARANG
    Route::post('/shop/bayar/{id}', [OrderController::class, 'buyNow'])
        ->name('shop.bayar');


    // ===============================
    // CART
    // ===============================
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/{product}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::patch('/cart/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{id}', [CartController::class, 'remove'])
        ->name('cart.remove');


    // ===============================
    // CHECKOUT
    // ===============================
    Route::get('/checkout', [CheckoutController::class,'index'])
        ->name('checkout');

    Route::post('/checkout/order',[CheckoutController::class,'createOrder'])
        ->name('checkout.order');


    // ===============================
    // PAYMENT (XENDIT)
    // ===============================
    Route::post('/payment/process',[PaymentController::class,'process'])
        ->name('payment.process');


    // ===============================
    // ORDERS
    // ===============================
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');


    // ===============================
    // PROFILE
    // ===============================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('/products', ProductController::class);
    });


require __DIR__.'/auth.php';