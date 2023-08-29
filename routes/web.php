<?php

use Illuminate\Support\Facades\Route;

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
    return view('list');
});

Route::get('/message', [\App\Http\Controllers\EventController::class, "getMessage"]);
Route::get('/revenue', [\App\Http\Controllers\EventController::class, "getRevenue"]);
Route::get('/followerNumber', [\App\Http\Controllers\EventController::class, "getFollowerNumber"]);
Route::get('/top3bestSale', [\App\Http\Controllers\EventController::class, "getTop3BestSale"]);
