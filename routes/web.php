<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\EventController;
use App\Models\Event;
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
    $events = Event::with('tickets')->get();
    // dd($events);
    return view('dashboard',  compact('events'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/event/add', [EventController::class, 'create'])->name('admin.event.create');
    Route::post('/event/store', [EventController::class, 'store'])->name('admin.event.store');
    Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('admin.event.edit');
    Route::post('/event/{id}/update', [EventController::class, 'update'])->name('admin.event.update');
    Route::get('/event/{id}/delete', [EventController::class, 'delete'])->name('admin.event.delete');
});


require __DIR__.'/auth.php';
