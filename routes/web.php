<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UsersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});


Route::redirect('/', '/login');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard', [DashboardController::class, 'query'])->name('dashboard.query');

Route::prefix('/admin')->middleware(['auth', 'verified', 'checkRole:admin'])->group(function () {
    Route::resource('users', UsersController::class);
});

Route::prefix('/tickets')->as('tickets.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [TicketsController::class, 'index'])->name('index');
    Route::get('/create', [TicketsController::class, 'create'])->name('create');
    Route::post('/', [TicketsController::class, 'store'])->name('store');
    Route::get('/tickets/{ticket:uuid}', [TicketsController::class, 'show'])->name('show');
    Route::post('/tickets/{ticket:uuid}', [TicketsController::class, 'close'])->name('close');
    Route::delete('/tickets/{ticket:uuid}', [TicketsController::class, 'destroy'])->name('destroy');
});

Route::prefix('/departments')->as('departments.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('index');
    Route::post('/', [DepartmentController::class, 'store'])->name('store');
});

require __DIR__.'/auth.php';
