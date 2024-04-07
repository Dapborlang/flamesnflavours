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
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\UserController;
Route::resource('users', UserController::class);

use App\Http\Controllers\RoleController;
Route::resource('roles', RoleController::class);

use App\Http\Controllers\UserRoleController;
Route::resource('user-roles', UserRoleController::class)->except(['create', 'edit']);

use App\Http\Controllers\TableController;
Route::resource('table', TableController::class);

use App\Http\Controllers\CategoryController;
Route::resource('categories', CategoryController::class);

use App\Http\Controllers\MenuItemController;
Route::resource('menu-items', MenuItemController::class);

use App\Http\Controllers\OrderController;
Route::resource('order',OrderController::class);
Route::get('/orders/detail', [OrderController::class, 'showPendingOrders']);
Route::get('/orders/{order}', [OrderController::class, 'getOrdersDetail']);
Route::post('/orders', [OrderController::class, 'getOrdersByStatus']);
Route::post('/orders/process/{orderId}', [OrderController::class, 'processOrder']);
Route::post('/orders/complete/{id}', [OrderController::class, 'completeOrder']);
Route::get('/print/{id}', [OrderController::class, 'printReceipt']);

use App\Http\Controllers\DashBoardController;
Route::get('/dashboard', [DashBoardController::class, 'index']);
Route::get('/dailysale', [DashBoardController::class, 'dailySale']);

use App\Http\Controllers\StockCategoryController;
Route::get('/stock_categories', [StockCategoryController::class, 'index']);
Route::post('/stock_categories', [StockCategoryController::class, 'store']);
Route::put('/stock_categories/{stockCategory}', [StockCategoryController::class, 'update']);
Route::delete('/stock_categories/{stockCategory}', [StockCategoryController::class, 'destroy']);

use App\Http\Controllers\StockController;

Route::get('/stocks', [StockController::class, 'index']);
Route::post('/stocks', [StockController::class, 'store']);
Route::put('/stocks/{stock}', [StockController::class, 'update']);
Route::delete('/stocks/{stock}', [StockController::class, 'destroy']);
Route::get('/stock-register', [StockController::class,'registerView']);