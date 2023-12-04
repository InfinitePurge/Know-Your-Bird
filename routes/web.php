<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BirdsListController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BirdFormsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\contact_usController;
use App\Http\Controllers\tagController;

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

Route::get('/birdlist/search', [BirdsListController::class, 'search'])->name('birdlist.search');
Route::get('/history', [HistoryController::class, 'index']);
Route::get('/contact_us', [contact_usController::class, 'index']);
Route::get('/birdforms', [BirdFormsController::class, 'index']);
Route::get('/birdlist', [BirdsListController::class, 'index'])->name('birds.index');
Route::get('/bird/{pavadinimas}', [BirdsListController::class, 'view'])->name('bird.view');
Route::get('/tagview', [tagController::class, 'index']);



Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['admin'])->group(function () {
//     // routes that should be accessible only to users with role 1(admin)
//     Route::get('/admin', [AdminController::class, 'index']);
// });

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__ . '/auth.php';

//ADMIN CONTROLLER
//routes that should be accessible only to users with role 1(admin)

Route::middleware(['admin'])->group(function () {
    Route::delete('/bird/delete/{id}', [AdminController::class, 'deleteBird'])->name('admin.bird.delete');
    Route::put('/admin/bird/edit/{birdId}', [AdminController::class, 'editBird'])->name('admin.editBird');
    Route::post('/admin/bird/add', [AdminController::class, 'addBird'])->name('admin.bird.add');
    Route::put('/admin/bird/edit/{birdId}', [AdminController::class, 'editBird'])->name('admin.editBird');
});