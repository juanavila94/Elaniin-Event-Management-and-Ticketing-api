<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    Route::get('events/list', [EventController::class, 'index'])->name('event.index');
    Route::get('events/details/{id}', [EventController::class, 'show'])->name('event.show');
    Route::post('events/create', [EventController::class, 'store'])->name('event.create');
    Route::put('events/update/{id}', [EventController::class, 'update'])->name('event.update');
    Route::delete('events/{id}', [EventController::class, 'destroy'])->name('event.delete');
});

require __DIR__ . '/auth.php';
