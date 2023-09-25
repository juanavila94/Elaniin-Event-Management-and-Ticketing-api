<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('attendees/create', [AttendeeController::class, 'store'])->name('attendee.create');
Route::post('order/create', [OrderController::class, 'store'])->name('order.create');
Route::get('list/orders', [OrderController::class, 'index'])->name('order.index');