<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Livewire\ShoppingCart;
use App\Http\Livewire\CreateOrder;
use App\Http\Controllers\WebhooksController;
use App\Http\Livewire\PaymentOrder;
use App\Models\Order;

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

Route::get('/', WelcomeController::class)->name('index');

Route::get('search', SearchController::class)->name('search');

Route::get('shopping-cart', ShoppingCart::class)->name('shopping-cart');

Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
*/

Route::middleware('auth')->group(function() {

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('orders/create', CreateOrder::class)->name('orders.create');
    
    Route::get('orders/{order}',  [OrderController::class, 'show'])->name('orders.show');
    
    // Route::get('orders/{order}/payment', [OrderController::class, 'payment'])->middleware('auth')->name('orders.payment');
    
    Route::get('orders/{order}/payment', PaymentOrder::class)->middleware('auth')->name('orders.payment');
    
    Route::get('orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    
    Route::post('webhooks', WebhooksController::class);


});

Route::get('prueba', function() {

    // $orders = Order::where('user_id', 1)->select('content')->get()->map(function($order) {
    //     return json_decode($order->content, true);
    // });

    // $products = $orders->collapse();
    // return $products->contains('id', 4) ? 'si' : 'no';
});

Route::post('reviews/{product}', [ReviewController::class, 'store'])->name('review.store');
