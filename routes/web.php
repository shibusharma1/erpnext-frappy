<?php

use App\Http\Controllers\Company\Admin\ERPNextOAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/docs', function () {
    return view('docs');
});


Route::prefix('admin/erpnext')->name('erpnext.')->group(function () {
    Route::get('/auth', [ERPNextOAuthController::class, 'showAuthPopup'])->name('auth');
    Route::get('/callback', [ERPNextOAuthController::class, 'callback'])->name('oauth.callback');
    Route::post('/disconnect', [ERPNextOAuthController::class, 'disconnect'])->name('oauth.disconnect');
    Route::get('/test-api', [ERPNextOAuthController::class, 'testApi'])->name('test.api');
});



Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/test', [CustomerController::class, 'ping'])->name('test');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{name}', [CustomerController::class, 'show'])->name('show');
    Route::get('/{name}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{name}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{name}', [CustomerController::class, 'destroy'])->name('destroy');
});

Route::prefix('items')->name('items.')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
    // Route::get('/test', [CustomerController::class, 'ping'])->name('test');
    Route::get('/create', [ItemController::class, 'create'])->name('create');
    Route::post('/', [ItemController::class, 'store'])->name('store');
    Route::get('/{name}', [ItemController::class, 'show'])->name('show');
    Route::get('/{name}/edit', [ItemController::class, 'edit'])->name('edit');
    Route::put('/{name}', [ItemController::class, 'update'])->name('update');
    Route::delete('/{name}', [ItemController::class, 'destroy'])->name('destroy');
});


Route::prefix('sales')->name('sales.')->group(function () {
    Route::get('/', [SalesOrderController::class, 'index'])->name('index');
    // Route::get('/test', [CustomerController::class, 'ping'])->name('test');
    Route::get('/create', [SalesOrderController::class, 'create'])->name('create');
    Route::post('/', [SalesOrderController::class, 'store'])->name('store');
    Route::get('/{name}', [SalesOrderController::class, 'show'])->name('show');
    Route::get('/{name}/edit', [SalesOrderController::class, 'edit'])->name('edit');
    Route::put('/{name}', [SalesOrderController::class, 'update'])->name('update');
    Route::delete('/{name}', [SalesOrderController::class, 'destroy'])->name('destroy');
});
