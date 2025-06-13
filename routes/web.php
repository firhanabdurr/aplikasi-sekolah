<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // CRUD Siswa
    Route::resource('students', StudentController::class);

    // Transaksi
    Route::post('students/{student}/savings', [StudentController::class, 'storeSaving'])->name('students.savings.store');
    Route::post('students/{student}/spp', [StudentController::class, 'storeSpp'])->name('students.spp.store');

    // Laporan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
});

require __DIR__.'/auth.php';

// Untuk menonaktifkan registrasi, ubah baris di bawah ini setelah mendaftar
// Auth::routes(['register' => false]);