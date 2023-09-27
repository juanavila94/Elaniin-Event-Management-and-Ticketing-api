<?php

use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\CSRFTokenController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController as ControllersPaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketTypeController;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\PaymentController;

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

Route::middleware('auth')->prefix('ticketTypes')->group(function () {

    Route::get('list', [TicketTypeController::class, 'index'])->name('ticketTypes.index');
    Route::post('create', [TicketTypeController::class, 'store'])->name('ticketType.create');
    Route::put('update/{id}', [TicketTypeController::class, 'update'])->name('ticketType.update');
    Route::delete('/{id}', [TicketTypeController::class, 'destroy'])->name('ticketType.destroy');
});


Route::prefix('attendees')->group(function () {
    Route::get('events/{id}', [EventController::class, 'show'])->name('attendee.event.show');
    Route::get('event/list', [EventController::class, 'index'])->name('attendee.event.index');
});





require __DIR__ . '/auth.php';
