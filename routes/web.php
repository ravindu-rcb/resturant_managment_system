<?php

use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('orders.index'));

Route::resource('concessions', ConcessionController::class);

Route::get('/orders/statuses', [OrderController::class, 'statuses'])->name('orders.statuses');

Route::resource('orders', OrderController::class)->only(['index','create','store','show','destroy']);
Route::post('/orders/{order}/send-now', [OrderController::class, 'sendNow'])->name('orders.sendNow');

Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
Route::post('/kitchen/{order}/complete', [KitchenController::class, 'complete'])->name('kitchen.complete');
Route::get('/kitchen/updates', [KitchenController::class, 'updates'])
    ->name('kitchen.updates');
