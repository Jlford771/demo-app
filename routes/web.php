<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\AgentsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// Frontend/Inertia Routes
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/agents/{clientId}', [AgentsController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('agents.index');


// API Routes
Route::middleware('auth')->group(function () {
    Route::get('/api/clients', [ClientController::class, 'index']);
    Route::get('/api/clients/{client}', [ClientController::class, 'edit']);
    Route::patch('/api/clients/{client}', [ClientController::class, 'update']);
    Route::post('/api/clients', [ClientController::class, 'store']);
    Route::delete('/api/clients/{client}', [ClientController::class, 'destroy']);
    Route::get('/api/trajectorySeries', [ClientController::class, 'getTrajectorySeries']);

});

require __DIR__.'/auth.php';
