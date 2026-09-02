<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'ideas');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [SessionsController::class, 'destroy']);
    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('idea.store');
});

Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('idea.show')->middleware('auth');
Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('idea.destroy');

Route::delete('/ideas/{idea}/image', [IdeaImageController::class, 'destroy'])->name('idea.image.destroy')->middleware('auth');

Route::patch('/steps/{step}', [StepController::class, 'update'])
    ->middleware('auth')
    ->name('steps.update');

Route::patch('/ideas/{idea}', [IdeaController::class, 'update'])->name('idea.update')->middleware('auth');

Route::get('/profile/edit', [ProfileController::class, 'edit'])
    ->name('profile.edit')
    ->middleware('auth');

Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update')
    ->middleware('auth');
