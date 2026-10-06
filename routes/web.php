<?php

use App\Http\Controllers\ExamAttemptController;
use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExamController::class, 'index'])->name('home');
Route::get('/exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
Route::post('/exams/{exam}/attempts', [ExamAttemptController::class, 'store'])->name('exams.attempts.store');
Route::get('/attempts/{attempt}', [ExamAttemptController::class, 'show'])->name('attempts.show');
