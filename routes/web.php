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

    // Grup Rute Manajemen Pengguna (Hanya Superadmin)
    Route::middleware('superadmin')->prefix('users')->as('users.')->group(function () {
        Route::get('/', \App\Livewire\Users\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Users\Form::class)->name('create');
        Route::get('/{user}/edit', \App\Livewire\Users\Form::class)->name('edit');
    });

    // Rute Index (Read-Only) sekarang bisa diakses Superadmin & Pimpinan
    Route::get('/users', \App\Livewire\Users\Index::class)
    ->middleware('can-access-users') // <-- Gunakan middleware baru di sini
    ->name('users.index');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Nanti, semua route admin lainnya (data warga, surat, dll) letakkan di dalam grup ini
});
