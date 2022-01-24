<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DeliveryController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home_fetch_data', [HomeController::class, 'fetch_pagination_data'])->name('fetch_data');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/product-{id}', [ProductController::class, 'view'])->name('product-view');
Route::get('/category-{id}', [CategoryController::class, 'view'])->name('category-view');
Route::get('/search', [ProductController::class, 'search'])->name('search');

Route::group(['middleware' => ['member']], function() {
    // -CART-
    Route::get('/cart', [CartController::class, 'view'])->name('cart-view');
    Route::get('/clearCart', [CartController::class, 'clear'])->name('cart-clear');

    // -ORDER-
    Route::post('/createOrder-{id}', [OrderController::class, 'create'])->name('add-to-cart');
    Route::post('/ajaxCartOrderIncrement', [OrderController::class, 'ajaxCartOrderIncrement'])->name('order-increment');
    Route::post('/ajaxCartOrderDecrement', [OrderController::class, 'ajaxCartOrderDecrement'])->name('order-decrement');
    Route::post('/ajaxCartOrderInput', [OrderController::class, 'ajaxCartOrderInput'])->name('order-input');
    Route::get('/removeOrder-{id}', [OrderController::class, 'delete'])->name('remove-from-cart');

    // -TRANSACTION-
    Route::post('/transactionConfirmed', [TransactionController::class, 'create'])->name('transaction-create');
    Route::get('/transaction-history', [TransactionController::class, 'view'])->name('transaction-view');
    Route::post('/uploadProof-{id}', [TransactionController::class, 'uploadProof'])->name('transaction-proof');
    Route::get('/checkout', [TransactionController::class, 'checkout'])->name('transaction-checkout');
});

Route::group(['middleware' => ['admin']], function() {
    // -PRODUCT-
    Route::get('/productcontrols', [ProductController::class, 'productControls'])->name('product-controls');
    Route::get('/productinsert', [ProductController::class, 'productInsert'])->name('product-insert');
    Route::post('/productcreate', [ProductController::class, 'create'])->name('product-create');
    Route::get('/productupdate-{id}', [ProductController::class, 'productUpdate'])->name('product-update-view');
    Route::post('/productupdateexecute-{id}', [ProductController::class, 'update'])->name('product-update');
    Route::get('/productdelete-{id}', [ProductController::class, 'delete'])->name('product-delete');

    // -CATEGORY-
    Route::get('/categorycontrols', [CategoryController::class, 'categoryControls'])->name('category-controls');
    Route::post('/categorycreate', [CategoryController::class, 'create'])->name('category-create');
    Route::get('/categoryupdate-{id}', [CategoryController::class, 'categoryUpdate'])->name('category-update-view');
    Route::post('/categoryupdateexecute-{id}', [CategoryController::class, 'update'])->name('category-update');
    Route::get('/categorydelete-{id}', [CategoryController::class, 'delete'])->name('category-delete');

    // -DELIVERY-
    Route::get('/deliverycontrols', [DeliveryController::class, 'deliveryControls'])->name('delivery-controls');
    Route::post('/deliverycreate', [DeliveryController::class, 'create'])->name('delivery-create');
    Route::get('/deliveryupdate-{id}', [DeliveryController::class, 'deliveryupdate'])->name('delivery-update-view');
    Route::post('/deliveryupdatexecute-{id}', [DeliveryController::class, 'update'])->name('delivery-update');
    Route::get('/deliverydelete-{id}', [DeliveryController::class, 'delete'])->name('delivery-delete');

    Route::get('/transactioncontrols', [TransactionController::class, 'transactionControls'])->name('transaction-controls');
    Route::get('/transactionaccept-{id}', [TransactionController::class, 'accept'])->name('transaction-accept');
    Route::get('/transactiondecline-{id}', [TransactionController::class, 'decline'])->name('transaction-decline');
    Route::get('/transactioncancel-{id}', [TransactionController::class, 'cancel'])->name('transaction-cancel');
});
