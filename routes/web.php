<?php

use App\Http\Controllers\Auth\MahasiswaAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/login', [MahasiswaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MahasiswaAuthController::class, 'login']);
    Route::get('/register', [MahasiswaAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [MahasiswaAuthController::class, 'register']);

    Route::middleware('auth:mahasiswa')->group(function () {
        Route::post('/logout', [MahasiswaAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard');

        Route::get('/feedback/create', [App\Http\Controllers\Mahasiswa\FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback', [App\Http\Controllers\Mahasiswa\FeedbackController::class, 'store'])->name('feedback.store');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });
});