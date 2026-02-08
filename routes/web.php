<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TopicsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'show'])->name('home.show');
Route::feeds();

Route::get('/home', function () {
    return redirect()->route('admin.show');
});
Route::get('/topics/{topic}', [TopicsController::class, 'show'])->name('topics.show');

Route::prefix('admin')->middleware('guest')->group(function () {
    Route::get('/', [SessionsController::class, 'show'])->name('sessions.show');
    Route::post('/', [SessionsController::class, 'store'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::controller(AdminController::class)->prefix('admin')->group(function () {
        Route::get('/index', 'show')->name('admin.show');
        Route::delete('/topics/{topic}', 'destroy')->name('admin.topics.destroy');
        Route::get('/create', 'create')->name('admin.create');
        Route::post('/create', 'store')->name('admin.store');
        Route::get('/profile', 'profile')->name('admin.profile');
        Route::post('/profile', 'updateProfile')->name('admin.profile.update');
        Route::post('/profile/password', 'updatePassword')->name('admin.profile.password');
        Route::get('/topics/{topic}', 'edit')->name('admin.topics.edit');
        Route::put('/topics/{topic}', 'update')->name('admin.topics.update');
        Route::post('/upload_image', 'uploadImage')->name('admin.upload_image');
    });
    Route::prefix('admin')->group(function () {
        Route::delete('/logout', [SessionsController::class, 'destroy'])->name('admin.logout');
    });
});
