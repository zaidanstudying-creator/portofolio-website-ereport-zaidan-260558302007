<?php

use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'createLogin'])->name('login');
    Route::post('login', [AuthController::class, 'storeLogin'])->middleware('throttle:login')->name('login.store');
    Route::get('register', [AuthController::class, 'createRegistration'])->name('register');
    Route::post('register', [AuthController::class, 'storeRegistration'])->middleware('throttle:register')->name('register.store');
    Route::get('forgot-password', [AuthController::class, 'createPasswordResetRequest'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendPasswordResetLink'])->middleware('throttle:password-reset')->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'createPasswordReset'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:password-reset')->name('password.update');
});

Route::post('logout', [AuthController::class, 'destroySession'])->middleware('auth')->name('logout');

Route::get('dashboard', function () {
    return auth()->user()->role === 'admin'
        ? to_route('admin.dashboard')
        : view('dashboard', [
            'counts' => auth()->user()->laporans()->selectRaw('status, count(*) as aggregate')->groupBy('status')->pluck('aggregate', 'status'),
            'recent' => auth()->user()->laporans()->latest()->take(6)->get(),
        ]);
})->middleware('auth')->name('dashboard');

Route::get('laporans/{laporan}/photo', [LaporanController::class, 'photo'])
    ->middleware('auth')
    ->name('laporans.photo');

Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::resource('laporans', LaporanController::class)->except(['destroy']);
    Route::delete('laporans/{laporan}', [LaporanController::class, 'destroy'])->name('laporans.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [AdminLaporanController::class, 'dashboard'])->name('dashboard');
    Route::get('laporans', [AdminLaporanController::class, 'index'])->name('laporans.index');
    Route::get('laporans/{laporan}', [AdminLaporanController::class, 'show'])->name('laporans.show');
    Route::patch('laporans/{laporan}/status', [AdminLaporanController::class, 'updateStatus'])->name('laporans.status');
});

require __DIR__.'/settings.php';
