<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeatReserveController;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [MovieController::class, 'index'])->name('home');

Route::post('/create', [MovieController::class, 'create'])->name('movie.create');
Route::get('/show', [MovieController::class, 'show'])->name('movie.show');
Route::get('/edit', [MovieController::class, 'edit'])->name('movie.edit');
Route::post('/update', [MovieController::class, 'update'])->name('movie.update');

Route::get('/index', [SeatReserveController::class, 'index'])->name('seat.index');
Route::get('/seat_show', [SeatReserveController::class, 'show'])->name('seat.show');
Route::post('/reserve', [SeatReserveController::class, 'reserve'])->name('seat.reserve');
