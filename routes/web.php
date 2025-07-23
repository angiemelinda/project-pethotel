<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AdminDataController;
use App\Http\Controllers\HewanPeliharaanController;
use App\Http\Controllers\LaporanExportController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;

Route::get('/', function () {
    return view('welcome');
});

// Redirect /pelanggan ke dashboard pelanggan
Route::get('pelanggan', function() {
    return redirect()->route('pelanggan.dashboard');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/staff', [AdminController::class, 'staff'])->name('admin.staff');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
    // Export PDF route only
    Route::get('/laporan/export/pdf', [App\Http\Controllers\LaporanExportController::class, 'exportPdf'])->name('admin.laporan.pdf');
});

// Admin Resource Routes for CRUD operations
Route::resource('admin/pelanggan', AdminController::class)->names([
    'index' => 'admin.pelanggan',
    'create' => 'admin.pelanggan.create',
    'store' => 'admin.pelanggan.store',
    'show' => 'admin.pelanggan.show',
    'edit' => 'admin.pelanggan.edit',
    'update' => 'admin.pelanggan.update',
    'destroy' => 'admin.pelanggan.destroy',
]);

Route::resource('admin/hewan', AdminController::class)->names([
    'index' => 'admin.hewan',
    'create' => 'admin.hewan.create',
    'store' => 'admin.hewan.store',
    'edit' => 'admin.hewan.edit',
    'update' => 'admin.hewan.update',
    'destroy' => 'admin.hewan.destroy',
]);

Route::resource('admin/transaksi', AdminController::class)->names([
    'index' => 'admin.transaksi',
    'create' => 'admin.transaksi.create',
    'store' => 'admin.transaksi.store',
    'edit' => 'admin.transaksi.edit',
    'update' => 'admin.transaksi.update',
    'destroy' => 'admin.transaksi.destroy',
]);

Route::resource('admin/staff', StaffController::class)->names([
    'index' => 'admin.staff',
    'create' => 'admin.staff.create',
    'store' => 'admin.staff.store',
    'edit' => 'admin.staff.edit',
    'update' => 'admin.staff.update',
    'destroy' => 'admin.staff.destroy',
]);

Route::resource('admin/admin', AdminDataController::class)->names([
    'index' => 'admin.admin',
    'create' => 'admin.admin.create',
    'store' => 'admin.admin.store',
    'edit' => 'admin.admin.edit',
    'update' => 'admin.admin.update',
    'destroy' => 'admin.admin.destroy',
]);

Route::resource('pelanggan/hewan', HewanPeliharaanController::class)
    ->names([
        'index' => 'pelanggan.hewan',
        'create' => 'pelanggan.hewan.create',
        'store' => 'pelanggan.hewan.store',
        'show' => 'pelanggan.hewan.show',
        'edit' => 'pelanggan.hewan.edit',
        'update' => 'pelanggan.hewan.update',
        'destroy' => 'pelanggan.hewan.destroy',
    ]);

// Transaksi untuk staff
Route::middleware(['auth:staff'])->prefix('staff')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\StaffController::class, 'dashboard'])->name('staff.dashboard');
    Route::get('transaksi', [App\Http\Controllers\StaffController::class, 'transaksiIndex'])->name('staff.transaksi');
    Route::get('transaksi/create', [App\Http\Controllers\StaffController::class, 'transaksiCreate'])->name('staff.transaksi.create');
    Route::post('transaksi', [App\Http\Controllers\StaffController::class, 'transaksiStore'])->name('staff.transaksi.store');
    Route::get('transaksi/{id}', [App\Http\Controllers\StaffController::class, 'transaksiShow'])->name('staff.transaksi.show');
    Route::get('transaksi/{id}/edit', [App\Http\Controllers\StaffController::class, 'transaksiEdit'])->name('staff.transaksi.edit');
    Route::put('transaksi/{id}', [App\Http\Controllers\StaffController::class, 'transaksiUpdate'])->name('staff.transaksi.update');
    Route::delete('transaksi/{id}', [App\Http\Controllers\StaffController::class, 'transaksiDestroy'])->name('staff.transaksi.destroy');
    Route::get('transaksi/{id}/cetak', [App\Http\Controllers\StaffController::class, 'transaksiCetak'])->name('staff.transaksi.cetak');
    Route::get('transaksi/history', [App\Http\Controllers\StaffController::class, 'transaksiHistory'])->name('staff.transaksi.history');

    // Resource route hewan untuk staff
    Route::get('hewan', [App\Http\Controllers\StaffController::class, 'hewanIndex'])->name('staff.hewan');
    Route::get('hewan/create', [App\Http\Controllers\StaffController::class, 'hewanCreate'])->name('staff.hewan.create');
    Route::post('hewan', [App\Http\Controllers\StaffController::class, 'hewanStore'])->name('staff.hewan.store');
    Route::get('hewan/{id}/edit', [App\Http\Controllers\StaffController::class, 'hewanEdit'])->name('staff.hewan.edit');
    Route::put('hewan/{id}', [App\Http\Controllers\StaffController::class, 'hewanUpdate'])->name('staff.hewan.update');
    Route::delete('hewan/{id}', [App\Http\Controllers\StaffController::class, 'hewanDestroy'])->name('staff.hewan.destroy');

    // Check-in & Check-out
    Route::get('checkin', [App\Http\Controllers\StaffController::class, 'checkinIndex'])->name('checkin');
    Route::get('checkout', [App\Http\Controllers\StaffController::class, 'checkoutIndex'])->name('checkout');
    Route::post('transaksi/{id}/update-status', [App\Http\Controllers\StaffController::class, 'updateStatus'])->name('transaksi.update_status');
    Route::get('penitipan', [App\Http\Controllers\StaffController::class, 'penitipanIndex'])->name('staff.penitipan');
    Route::post('penitipan/{id}/update-status', [App\Http\Controllers\StaffController::class, 'updateStatusLayanan'])->name('staff.penitipan.update_status');
    Route::resource('jadwal-layanan', App\Http\Controllers\JadwalLayananController::class)->names([
        'index' => 'staff.jadwal-layanan.index',
        'create' => 'staff.jadwal-layanan.create',
        'store' => 'staff.jadwal-layanan.store',
        'edit' => 'staff.jadwal-layanan.edit',
        'update' => 'staff.jadwal-layanan.update',
        'destroy' => 'staff.jadwal-layanan.destroy',
    ])->except(['show']);
    Route::post('jadwal-layanan/{id}/update-status', [App\Http\Controllers\JadwalLayananController::class, 'updateStatus'])->name('staff.jadwal-layanan.update_status');
});

Route::prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
    Route::get('/booking', [App\Http\Controllers\PelangganController::class, 'booking'])->name('pelanggan.booking');
    Route::get('/booking/create', [App\Http\Controllers\PelangganController::class, 'bookingCreate'])->name('pelanggan.booking.create');
    Route::post('/booking/store', [App\Http\Controllers\PelangganController::class, 'bookingStore'])->name('pelanggan.booking.store');
    Route::get('/transaksi', [App\Http\Controllers\PelangganController::class, 'transaksi'])->name('pelanggan.transaksi');
    Route::get('/profile', [App\Http\Controllers\PelangganController::class, 'profile'])->name('pelanggan.profile');
    Route::post('/profile/update', [App\Http\Controllers\PelangganController::class, 'profileUpdate'])->name('pelanggan.profile.update');
});

// Register pelanggan
Route::get('/register', function() {
    return view('pelanggan.register');
})->name('register');
Route::post('/register', [App\Http\Controllers\PelangganController::class, 'register'])->name('register.post');

// Ganti password untuk staff
Route::get('/staff/change-password', [App\Http\Controllers\StaffController::class, 'showChangePasswordForm'])->name('staff.change_password');
Route::post('/staff/change-password', [App\Http\Controllers\StaffController::class, 'changePassword'])->name('staff.update_password');

// Ganti password untuk admin
Route::get('/admin/change-password', [App\Http\Controllers\AdminController::class, 'showChangePasswordForm'])->name('admin.change_password');
Route::post('/admin/change-password', [App\Http\Controllers\AdminController::class, 'changePassword'])->name('admin.update_password');

Route::middleware(['auth:admin,staff'])->group(function () {
    Route::resource('layanan', App\Http\Controllers\LayananController::class)->names([
        'index' => 'layanan.index',
        'create' => 'layanan.create',
        'store' => 'layanan.store',
        'edit' => 'layanan.edit',
        'update' => 'layanan.update',
        'destroy' => 'layanan.destroy',
    ])->except(['show']);
});

// Route untuk update status jadwal layanan oleh admin dan staff
Route::post('admin/jadwal-layanan/{id}/update-status', [App\Http\Controllers\AdminController::class, 'updateJadwalStatus'])->name('admin.jadwal.updateStatus');

Route::get('admin/status-layanan', function() {
    return view('admin.status_layanan');
})->name('admin.statusLayanan');

Route::get('staff/status-layanan', function() {
    return view('staff.status_layanan');
})->name('staff.statusLayanan');
