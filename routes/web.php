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
    Route::get('transactions/{transactions}/print-invoice', [App\Http\Controllers\TransactionsController::class, 'printInvoice']);

    /*--------------------------------------------------------------------------
    | Apriori Routes
    |--------------------------------------------------------------------------*/
    Route::resource('apriori-analysis', AprioriController::class);
    // Route::get('apriori-analysis/combine/test', [App\Http\Controllers\AprioriController::class, 'combineTest']);
    Route::get('apriori-analysis/combine/test2', [App\Http\Controllers\AprioriController::class, 'combineTest2']);
    Route::get('apriori-analysis/combine/test3', [App\Http\Controllers\AprioriController::class, 'combineTest3']);
    // Route::get('apriori-analysis/combine/test4', [App\Http\Controllers\AprioriController::class, 'combineTest4']);
    // Route::get('apriori-analysis/combine/test5', [App\Http\Controllers\AprioriController::class, 'combineTest5']);
    // Route::get('apriori-analysis/combine/test6', [App\Http\Controllers\AprioriController::class, 'combineTest6']);
    Route::get('apriori-analysis/combine/test7', [App\Http\Controllers\AprioriController::class, 'combineTest7']);
    Route::get('apriori-analysis/combine/test8', [App\Http\Controllers\AprioriController::class, 'combineTest8']);
    
    /*--------------------------------------------------------------------------
    | Counting, Chart & Etc
    |--------------------------------------------------------------------------*/
    Route::get('count/revenue-sources', [App\Http\Controllers\CountController::class, 'revenueSource']);
    Route::get('count/earnings-overview', [App\Http\Controllers\CountController::class, 'earningsOverview']);
});
