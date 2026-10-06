<?php

use App\Http\Controllers\ExamAttemptController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
Route::post('/exams/{exam}/attempts', [ExamAttemptController::class, 'store'])->name('exams.attempts.store');
Route::get('/attempts/{attempt}', [ExamAttemptController::class, 'show'])->name('attempts.show');
Route::get('/guides/{slug}', [GuideController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('guides.show');
