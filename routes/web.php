<?php

use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('loan')->name('loan.')->controller(LoanController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/detail', 'loanDetail')->name('detail');
    Route::post('/process', 'processEmi')->name('process');
});

require __DIR__ . '/auth.php';
