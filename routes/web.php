<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\AprioriController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /*--------------------------------------------------------------------------
    | Product Routes
    |--------------------------------------------------------------------------*/
    Route::resource('products', ProductsController::class);
    Route::get('products/data/all', [App\Http\Controllers\ProductsController::class, 'showAll']);
    Route::post('products/{products}/add-stock/', [App\Http\Controllers\ProductsController::class, 'addStock']);

    /*--------------------------------------------------------------------------
    | Transaction Routes
    |--------------------------------------------------------------------------*/
    Route::resource('transactions', TransactionsController::class);
    Route::get('transactions/data/all', [App\Http\Controllers\TransactionsController::class, 'showAll']);

    /*--------------------------------------------------------------------------
    | Apriori Routes
    |--------------------------------------------------------------------------*/
    Route::resource('apriori', AprioriController::class);

    /*--------------------------------------------------------------------------
    | Counting, Chart & Etc
    |--------------------------------------------------------------------------*/
    Route::get('count/revenue-sources', [App\Http\Controllers\CountController::class, 'revenueSource']);
    Route::get('count/earnings-overview', [App\Http\Controllers\CountController::class, 'earningsOverview']);
});
