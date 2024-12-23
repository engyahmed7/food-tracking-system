<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/',
    [
        HomeController::class,
        'index',
    ]
)->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // cart 
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

    // categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('category.show');

    //  payment

    Route::post('/payment/process', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment-cancel', [PaymentController::class, 'paymentFailure'])->name('payment.cancel');


    // checkout
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');

    // order

    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'track'])->name('order.track');

    Route::post('/shipping/calculate', [ShippingController::class, 'calculateShipping'])->name('shipping.calculate');

    Route::post('/address/check', [ShippingController::class, 'checkAddress'])->name('address.check');

    Route::get('/shipping/countries', [ShippingController::class, 'getCountries'])->name('shipping.countries');
    Route::get('/shipping/cities', [ShippingController::class, 'getCities'])->name('shipping.cities');
    Route::post('/shipping/calculate', [ShippingController::class, 'calculateShipping'])->name('shipping.calculate');
});

require __DIR__ . '/auth.php';
