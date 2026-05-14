<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuestionImportController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\QuizTestSeriesController;
use App\Http\Controllers\QuizzesController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectTopicController;
use App\Http\Controllers\SubjectTopicLectureController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/users/export', [UserController::class, 'export'])
            ->name('users.export');
        Route::resource('users', UserController::class);

        Route::resource('categories', CategoryController::class);
        Route::resource('course', CourseController::class);
        Route::post('/courses-popular', [CourseController::class, 'isPopular'])->name('courses-popular');

        Route::resource('subjects', SubjectController::class);
        Route::resource('topics', SubjectTopicController::class);
        Route::resource('lectures', SubjectTopicLectureController::class);
        Route::resource('banners', BannerController::class);
        Route::resource('testseries', QuizTestSeriesController::class);
        Route::resource('quizzes', QuizzesController::class);
        Route::resource('questions', QuestionsController::class);
        Route::post('/questions/import', [QuestionsController::class, 'import'])
            ->name('questions.import');
        // Route::post('/questions/import-docx', [QuestionImportController::class, 'import']);
    });
