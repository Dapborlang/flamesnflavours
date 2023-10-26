<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\TableController;
Route::resource('table', TableController::class);

use App\Http\Controllers\CategoryController;
Route::resource('categories', CategoryController::class);

use App\Http\Controllers\MenuItemController;
Route::resource('menu-items', MenuItemController::class);

use App\Http\Controllers\OrderController;
Route::resource('order',OrderController::class);
Route::get('/order/{order}', [OrderController::class, 'showOrderSummary'])->name('order.summary');
Route::get('/orders/detail', [OrderController::class, 'showPendingOrders']);
Route::get('/orders/{order}', [OrderController::class, 'getOrdersDetail']);
Route::post('/orders', [OrderController::class, 'getOrdersByStatus']);
Route::post('/orders/process/{orderId}', [OrderController::class, 'processOrder']);
Route::post('/orders/complete/{id}', [OrderController::class, 'completeOrder']);
Route::get('/print/{id}', [OrderController::class, 'printReceipt']);

use App\Http\Controllers\DashBoardController;
Route::get('/dashboard', [DashBoardController::class, 'index']);