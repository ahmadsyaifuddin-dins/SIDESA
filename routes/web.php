<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Rute Halaman Welcome (Publik)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route untuk tamu (yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Route yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/profile', \App\Livewire\Profile\UpdateForm::class)->name('profile.edit');

    // --- GRUP RUTE MANAJEMEN WARGA ---
    Route::prefix('warga')->as('warga.')->group(function () {
        // Rute untuk halaman utama (tabel data)
        Route::get('/', \App\Livewire\Warga\Index::class)->name('index');

        // Rute untuk halaman detail warga (BARU)
        // Pastikan ini di bawah rute spesifik lainnya jika ada nanti
        Route::get('/{warga}', \App\Livewire\Warga\Show::class)->name('show');
    });
    
    // --- Rute Pengaturan & Manajemen (Khusus Superadmin) ---
    Route::middleware('superadmin')->group(function () {
        // Rute Log Aktivitas
        Route::get('/activity-log', \App\Livewire\ActivityLog\Index::class)->name('activity-log.index');
    });

    // Grup Rute Manajemen Pengguna dengan urutan yang benar
    Route::prefix('users')->as('users.')->group(function () {

        // Rute paling spesifik diletakkan paling atas
        Route::get('/create', \App\Livewire\Users\Form::class)
            ->middleware('superadmin')
            ->name('create');

        // Rute umum (index)
        Route::get('/', \App\Livewire\Users\Index::class)
            ->middleware('can-access-users')
            ->name('index');

        // Rute dinamis/wildcard diletakkan di bawah rute spesifik
        Route::get('/{user}', \App\Livewire\Users\Show::class)
            ->middleware('can-access-users')
            ->name('show');

        Route::get('/{user}/edit', \App\Livewire\Users\Form::class)
            ->middleware('superadmin')
            ->name('edit');
    });
});
