<?php

use App\Http\Controllers\Admin\PdfReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\FeedbackController;
use App\Http\Controllers\User\MaintenanceController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }
    return match (Auth::user()->role) {
        'admin' => redirect('/admin'),
        'teknisi' => redirect('/teknisi'),
        default => redirect()->route('user.dashboard'),
    };
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/reports/pdf')
    ->name('admin.reports.pdf.')
    ->group(function (): void {
        Route::get('/bookings', [PdfReportController::class, 'bookings'])->name('bookings');
        Route::get('/payments', [PdfReportController::class, 'payments'])->name('payments');
        Route::get('/tenants', [PdfReportController::class, 'tenants'])->name('tenants');
        Route::get('/maintenance', [PdfReportController::class, 'maintenance'])->name('maintenance');
        Route::get('/feedback', [PdfReportController::class, 'feedback'])->name('feedback');
    });

Route::middleware(['auth', 'role:penghuni'])
    ->prefix('user')
    ->name('user.')
    ->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
        Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('maintenance.create');
        Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
        Route::get('/maintenance/{maintenanceReport}/edit', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
        Route::put('/maintenance/{maintenanceReport}', [MaintenanceController::class, 'update'])->name('maintenance.update');
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });