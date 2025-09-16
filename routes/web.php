<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Rute Halaman Welcome (Publik)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route untuk tamu (yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Route yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', \App\Livewire\Profile\UpdateForm::class)->name('profile.edit');

    // Grup Rute Manajemen Pengguna
    Route::prefix('users')->as('users.')->group(function () {

        // Rute yang bisa diakses Superadmin & Pimpinan
        Route::middleware('can-access-users')->group(function () {
            Route::get('/', \App\Livewire\Users\Index::class)->name('index');
            Route::get('/{user}', \App\Livewire\Users\Show::class)->name('show');
        });

        // Rute yang HANYA bisa diakses Superadmin
        Route::middleware('superadmin')->group(function () {
            Route::get('/create', \App\Livewire\Users\Form::class)->name('create');
            Route::get('/{user}/edit', \App\Livewire\Users\Form::class)->name('edit');
        });
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Nanti, semua route admin lainnya (data warga, surat, dll) letakkan di dalam grup ini
});
