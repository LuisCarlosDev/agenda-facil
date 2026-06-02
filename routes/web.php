<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\WorkScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/agendamentos', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/agendamentos', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/servicos', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/servicos/opcoes', [ServiceController::class, 'options'])->name('services.options');
    Route::get('/servicos/agendamento', [ServiceController::class, 'bookingOptions'])->name('services.booking-options');
    Route::post('/servicos', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/horarios', [WorkScheduleController::class, 'index'])->name('schedules.index');
    Route::post('/horarios', [WorkScheduleController::class, 'update'])->name('schedules.update');
    Route::post('/horarios/preview', [WorkScheduleController::class, 'preview'])->name('schedules.preview');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
