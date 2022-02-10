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
    Route::get('apriori-analysis/combine2/proccess', [App\Http\Controllers\AprioriController::class, 'combineSecondProccess']);
    Route::get('apriori-analysis/combine2/rules', [App\Http\Controllers\AprioriController::class, 'combineSecondRules']);

    Route::get('apriori-analysis/combine1/proccess', [App\Http\Controllers\AprioriController::class, 'comb1proccessJson']);
    Route::get('apriori-analysis/combine1/rules', [App\Http\Controllers\AprioriController::class, 'comb1rulesJson']);
    Route::get('apriori-analysis/testing/test', [App\Http\Controllers\AprioriController::class, 'testing']);
    // Route::post('apriori-analysis/combine-results/', [App\Http\Controllers\AprioriController::class, 'combine-results']);

    /*--------------------------------------------------------------------------
    | Counting, Chart & Etc
    |--------------------------------------------------------------------------*/
    Route::get('count/revenue-sources', [App\Http\Controllers\CountController::class, 'revenueSource']);
    Route::get('count/earnings-overview', [App\Http\Controllers\CountController::class, 'earningsOverview']);

    /*--------------------------------------------------------------------------
    | Records
    |--------------------------------------------------------------------------*/
    Route::get('reports/list', [App\Http\Controllers\ReportsController::class, 'index'])->name('reports-list');
    Route::get('reports/trans/day/{reports}', [App\Http\Controllers\ReportsController::class, 'reportsTransDay']);
    Route::get('reports/trans/month/{reports}', [App\Http\Controllers\ReportsController::class, 'reportsTransMonth']);
    Route::get('reports/trans/year/{reports}', [App\Http\Controllers\ReportsController::class, 'reportsTransYear']);

});
