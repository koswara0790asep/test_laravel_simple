<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductTransactionController;

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// --- RUTE GUEST (Hanya untuk pengguna yang BELUM login) ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// --- RUTE LOGOUT (Untuk pengguna yang SUDAH login) ---
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// --- RUTE KHUSUS ROLE STAFF ---
Route::middleware(['auth', 'role:staff,user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.dashboard');
    })->name('dashboard');

    Route::get('/log-activities', [LogActivityController::class, 'index'])->name('log_activities.index');
});

Route::middleware(['auth', 'role:staff'])->group(function () {
    
    Route::get('/siswa', function () {
        return view('siswa.index', ['nilai' => 75]);
        })->name('siswa.index');
        
    Route::resource('users', UserController::class);

    // Route::get('/log-activities', [LogActivityController::class, 'index'])->name('log_activities.index');
    Route::delete('/log-activities/clear', [LogActivityController::class, 'destroyAll'])->name('log_activities.clear');


    Route::get('/products', [ProductTransactionController::class, 'index'])->name('products.index');
    Route::post('/checkout', [ProductTransactionController::class, 'store'])->name('products.checkout');
    Route::get('/history', [ProductTransactionController::class, 'history'])->name('transactions.history');
    
    // Route Halaman Cetak Laporan PDF Transaksi
    Route::get('/transactions/print-history', [ProductTransactionController::class, 'printHistory'])
        ->name('transactions.print_history');



    // Route::get('/dashboard', function () {
    //     return view('layouts.dashboard');
    // })->name('dashboard');
});

// --- RUTE KHUSUS ROLE USER ---
Route::middleware(['auth', 'role:user'])->group(function () {
    // Route::get('/dashboard', function () {
    //     return view('layouts.dashboard');
    // })->name('dashboard');
});


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/hello', function () {
//     return view('hello', ['name' => 'Jhon Doe']);
// });

// Route::get('/dashboard', function () {
//     return view('layouts.dashboard');
// })->name('layouts.dashboard');

// Route::get('/siswa', function () {
//     return view('siswa.index', ['nilai' => 75]);
// })->name('siswa.index');

// Route::resource('users', UserController::class);