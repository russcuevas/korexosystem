<?php

use App\Http\Controllers\admin\TicketingController;
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



Route::get('/reference_number', [ReferenceNumberController::class, 'ReferenceNumberPage'])->name('reference.number.page');
Route::post('/check-ticket', [ReferenceNumberController::class, 'CheckTicket'])->name('check.ticket');

Route::get('/home', [HomeController::class, 'HomePage'])->name('home.page');


Route::get('/admin/ticketing', [TicketingController::class, 'AdminTicketingPage'])->name('admin.ticketing.page');