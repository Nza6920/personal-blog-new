<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TopicsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'show'])->name('home.show');

Route::get('/home', function () {
    return redirect()->route('admin.show');
});

Route::get('/topics/{topic}', [TopicsController::class, 'show'])->name('topics.show');

Route::middleware('guest')->group(function () {
    Route::get('/admin', [SessionsController::class, 'show'])->name('sessions.show');
    Route::post('/admin', [SessionsController::class, 'store'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/index', [AdminController::class, 'show'])->name('admin.show');
    Route::delete('admin/delete/{topic}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('admin/create', [AdminController::class, 'store'])->name('admin.store');
    Route::post('upload_image', [AdminController::class, 'uploadImage'])->name('admin.upload_image');
    Route::delete('logout', [SessionsController::class, 'destroy'])->name('logout');
    Route::get('admin/edit/{topic}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('admin/update/{topic}', [AdminController::class, 'update'])->name('admin.update');
});
