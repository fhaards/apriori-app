<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
});
