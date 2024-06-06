<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\DB;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test', function () {
    $user = DB::table('users')->first();
    return $user->name;
});

Route::get('/', function () 
{
    return Auth::check() ? redirect()->route('quizzes.index') : view('auth.register');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // quizルート
    Route::delete('/quizzes/destroy-selected', [QuizController::class, 'destroySelected'])->name('quizzes.destroy-selected');
    Route::delete('/quizzes/force-destroy-selected', [QuizController::class, 'forceDestroySelected'])->name('quizzes.force-destroy-selected');
    Route::delete('/quizzes/all-force-destroy', [QuizController::class, 'AllForceDestroy'])->name('quizzes.all-force-destroy');
    Route::delete('/quizzes/{id}/force-destroy', [QuizController::class, 'forceDestroy'])->name('quizzes.force-destroy');
    Route::get('/quizzes/trashed', [QuizController::class, 'trashed'])->name('quizzes.trashed');
    Route::post('/quizzes/{id}/restore', [QuizController::class, 'restore'])->name('quizzes.restore');
    Route::post('/quizzes/restore-selected', [QuizController::class, 'restoreSelected'])->name('quizzes.restore-selected');
    Route::resource('quizzes', QuizController::class);
    
    // labelルート
    Route::resource('labels', LabelController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);
});

require __DIR__.'/auth.php';