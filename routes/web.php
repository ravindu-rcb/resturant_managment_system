<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KitchenController;

/*
|--------------------------------------------------------------------------
| Auth (guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'show'])->name('login');
    Route::post('/login',   [LoginController::class, 'authenticate'])->name('login.attempt');

    Route::get('/register', [RegisteredUserController::class, 'show'])->name('register');
    Route::post('/register',[RegisteredUserController::class, 'store'])->name('register.store');
});

/*
|--------------------------------------------------------------------------
| Logout (auth)
|--------------------------------------------------------------------------
*/
Route::post('/logout', LogoutController::class)->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Home redirect based on role (auth) or to login (guest)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    $role = auth()->user()->role ?? 'cashier';
    return redirect()->route(match ($role) {
        'cook'    => 'kitchen.index',
        'manager' => 'concessions.index',
        default   => 'orders.index', // cashier
    });
});

/*
|--------------------------------------------------------------------------
| App routes (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Concessions
    Route::resource('concessions', ConcessionController::class);

    // Orders
    Route::resource('orders', OrderController::class)->only(['index','create','store','show','destroy']);
    Route::post('/orders/{order}/send-now', [OrderController::class, 'sendNow'])->name('orders.sendNow');
    Route::get('/orders/statuses', [OrderController::class, 'statuses'])->name('orders.statuses');

    // Kitchen
    Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
    Route::post('/kitchen/{order}/complete', [KitchenController::class, 'complete'])->name('kitchen.complete');
    Route::get('/kitchen/updates', [KitchenController::class, 'updates'])->name('kitchen.updates');
});
