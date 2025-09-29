<?php

use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->controller(LoanController::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');
    Route::get('/loan/detail', 'loanDetail')->name('loan.detail');
    Route::post('/loan/process', 'processEmi')->name('loan.process');
});

require __DIR__ . '/auth.php';
