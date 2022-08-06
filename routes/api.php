<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('order-details', App\Http\Controllers\OrderController::class)->only(['index', 'store']);
Route::resource('currency-list', App\Http\Controllers\CurrencyController::class)->only(['index']);
