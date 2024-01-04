<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BirdsListController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BirdFormsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\contact_usController;
use App\Http\Controllers\tagController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ManageUsers;
use App\Http\Controllers\AdminQuizzController;

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

Route::get('/birdlist/search', [BirdsListController::class, 'index'])->name('birdlist.search');
Route::get('/history', [HistoryController::class, 'index']);
Route::get('/birdforms', [BirdFormsController::class, 'index']);
Route::get('/birdlist', [BirdsListController::class, 'index'])->name('birds.index');
Route::get('/bird/{pavadinimas}', [BirdsListController::class, 'view'])->name('bird.view');
Route::get('/birdlist/filter', [BirdsListController::class, 'index'])->name('birdlist.filter');

// Quiz routes
Route::get('/theme', [QuizzController::class, 'theme'])->name('theme');
Route::get('/quizz/{title}', [QuizzController::class, 'index'])->name('quiz');
Route::post('/answer/{title}', [QuizzController::class, 'answerQuestion'])->name('answer');
Route::get('/quiz_completed/{title}', [QuizzController::class, 'quiz_completed'])->name('quiz_completed');


//Contact us
Route::get('/contact_us', [contact_usController::class, 'index']);
Route::post('/contact_us', [contact_usController::class, 'submit']);

// Route::get('/dashboard', function () {
//     return view('welcome');
// })->middleware(['auth', 'verified'])->name('dashboard');

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
    // Tagview routes for admin
    Route::get('/tagview', [tagController::class, 'index']);
    Route::delete('/tag/delete/{id}', [AdminController::class, 'deleteTag'])->name('admin.tag.delete');
    Route::delete('/prefix/delete/{id}', [AdminController::class, 'deletePrefix'])->name('admin.prefix.delete');
    Route::post('/admin/prefix/add', [AdminController::class, 'addPrefix'])->name('admin.prefix.add');
    Route::post('/admin/tag/add', [AdminController::class, 'addTag'])->name('admin.tag.add');
    Route::post('/admin/tagprefix/add', [AdminController::class, 'addTagWithPrefix'])->name('admin.tag.add.prefix');
    Route::put('/admin/prefix/update/{id}', [AdminController::class, 'updatePrefix'])->name('admin.prefix.update');
    Route::put('/admin/tag/update/{id}', [AdminController::class, 'updateTagAndPrefix'])->name('admin.tag.update');
    // Manage users for admin
    Route::get('/adminpanel', [ManageUsers::class, 'index'])->name('adminpanel');
    Route::delete('/deleteuser/{id}', [ManageUsers::class, 'deleteUser'])->name('admin.user.delete');
    Route::delete('/admin/users/deleteSelected', [ManageUsers::class, 'deleteSelected'])->name('admin.users.deleteSelected');
    Route::put('/adminpanel/user/{id}/role', [ManageUsers::class, 'updateRole'])->name('adminpanel.updateRole');
    Route::post('/adminpanel/user/{id}/username', [ManageUsers::class, 'updateUsername'])->name('adminpanel.updateUsername');
    Route::post('/adminpanel/user/{id}/email', [ManageUsers::class, 'updateEmail'])->name('adminpanel.updateEmail');
    Route::post('/adminpanel/user/{id}/password', [ManageUsers::class, 'updatePassword'])->name('adminpanel.updatePassword');
    // Quizz routes for admin
    Route::get('/addquiz', [AdminQuizzController::class, 'index']);
    Route::get('/quiz/questions/{themeId}', [AdminQuizzController::class, 'getQuestionsByTheme'])->name('admin.quiz.questions');
    Route::delete('/addquiz/deleteTheme/{id}', [AdminQuizzController::class, 'deleteTheme'])->name('admin.quiz.delete');
    Route::post('/addquiz/editThemeTitle', [AdminQuizzController::class, 'editThemeTitle'])->name('admin.quiz.editThemeTitle');
    Route::post('/addquiz/addTheme', [AdminQuizzController::class, 'addTheme'])->name('admin.quiz.addTheme');
});
