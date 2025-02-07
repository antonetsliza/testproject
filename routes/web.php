<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\PermittedEditTask;
use Illuminate\Support\Facades\Route;

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

    Route::resource('tasks', TaskController::class)->except(['edit', 'update']);

    Route::middleware(PermittedEditTask::class)->group(function () {
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

        Route::patch('/tasks/complete/{task}', [TaskController::class, 'completeTask'])->name('tasks.complete');
        Route::patch('/tasks/assign/{task}', [TaskController::class, 'assignUser'])->name('tasks.assign-update');
        Route::get('/tasks/{task}/assign', [TaskController::class, 'assignUserForm'])->name('tasks.assign-edit');
    });
});

require __DIR__.'/auth.php';
