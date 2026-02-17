<?php

use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\TicketingController;
use App\Http\Controllers\CartCountsController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DefaultMenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReferenceNumberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/reference_number', [ReferenceNumberController::class, 'ReferenceNumberPage'])
    ->name('reference.number.page')
    ->middleware('redirect.if.verified');
Route::post('/check-ticket', [ReferenceNumberController::class, 'CheckTicket'])->name('check.ticket');


Route::get('/home', [HomeController::class, 'HomePage'])->name('home.page')->middleware('check.reference');
Route::get('/category', [CategoryController::class, 'CategoryPage'])->name('category.page')->middleware('check.reference');
Route::get('/menu/{category_id}', [DefaultMenuController::class, 'DefaultMenuPage'])->name('default.menu.page')->middleware('check.reference');
Route::post('/cart/add', [CartsController::class, 'AddToCart'])->name('cart.add');
Route::delete('/cart/delete/{id}', [CartsController::class, 'DeleteCartItem'])->name('cart.delete');
Route::get('/cart/count', [CartCountsController::class, 'FetchCartCountAjax'])->name('cart.count');
Route::get('/cart', [CartsController::class, 'CartPage'])->name('cart.page');


Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

Route::get('/admin/menu', [MenuController::class, 'AdminMenuPage'])->name('admin.menu.page');
Route::get('/admin/ticketing', [TicketingController::class, 'AdminTicketingPage'])->name('admin.ticketing.page');
