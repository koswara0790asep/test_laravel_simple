<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello', ['name' => 'Jhon Doe']);
});

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
})->name('layouts.dashboard');

Route::get('/siswa', function () {
    return view('siswa.index', ['nilai' => 75]);
})->name('siswa.index');

Route::resource('users', UserController::class);