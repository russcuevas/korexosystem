<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\MenuController;
use App\Http\Controllers\admin\OrdersController;
use App\Http\Controllers\admin\QrController;
use App\Http\Controllers\admin\TicketingController;
use App\Http\Controllers\auth\AuthController;
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


Route::get('/', function () {
    return redirect()->route('reference.number.page');
});
Route::get('/reference_number', [ReferenceNumberController::class, 'ReferenceNumberPage'])->name('reference.number.page')->middleware('redirect.if.verified');
Route::post('/check-ticket', [ReferenceNumberController::class, 'CheckTicket'])->name('check.ticket');


Route::get('/home', [HomeController::class, 'HomePage'])->name('home.page')->middleware('check.reference');
Route::get('/category', [CategoryController::class, 'CategoryPage'])->name('category.page')->middleware('check.reference');
Route::get('/menu/{category_id}', [DefaultMenuController::class, 'DefaultMenuPage'])->name('default.menu.page')->middleware('check.reference');
Route::post('/cart/add', [CartsController::class, 'AddToCart'])->name('cart.add')->middleware('check.reference');;
Route::delete('/cart/delete/{id}', [CartsController::class, 'DeleteCartItem'])->name('cart.delete')->middleware('check.reference');;
Route::get('/cart/count', [CartCountsController::class, 'FetchCartCountAjax'])->name('cart.count')->middleware('check.reference');;
Route::get('/cart', [CartsController::class, 'CartPage'])->name('cart.page')->middleware('check.reference');;
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout')->middleware('check.reference');;
Route::get('/purchase-success/{reference_number}', [CheckoutController::class, 'PurchaseSuccessPage'])->name('purchase.success');


Route::get('/admin/login', [AuthController::class, 'AdminLoginPage'])
    ->name('admin.login.page');

Route::post('/admin/login', [AuthController::class, 'AdminLogin'])
    ->name('admin.login');

Route::post('/admin/logout', [AuthController::class, 'Logout'])
    ->name('admin.logout');




Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'DashboardPage'])->name('admin.dashboard.page');
    Route::get('/admin/menu', [MenuController::class, 'AdminMenuPage'])->name('admin.menu.page');
    Route::get('/admin/ticketing', [TicketingController::class, 'AdminTicketingPage'])->name('admin.ticketing.page');
    Route::get('/admin/orders', [OrdersController::class, 'OrdersPage'])->name('admin.orders.page');
    Route::get('/admin/orders/search', [OrdersController::class, 'search'])->name('admin.orders.search');
    Route::get('/admin/orders/fetch', [OrdersController::class, 'fetchOrders'])->name('admin.orders.fetch');
    Route::get('/admin/orders/items/{ref}', [OrdersController::class, 'getItems']);
    Route::post('/admin/orders/item/serve', [OrdersController::class, 'serveItem']);
    Route::post('/admin/orders/complete-all', [OrdersController::class, 'completeAll']);
    Route::post('/admin/orders/update-status', [OrdersController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/admin/orders/receipt/{ref}', [OrdersController::class, 'printReceipt'])->name('admin.orders.receipt');

    Route::get('/qr-code/{referenceNumber}', [QrController::class, 'ShowQrOrder'])->name('admin.qr.show');
});
