<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/profile/update', [UserApiController::class, 'update']);

    Route::post('/home', [CourseApiController::class, 'home']);
    Route::get('/exams', [CourseApiController::class, 'exams']);
    Route::post('/courses', [CourseApiController::class, 'courses']);
    Route::post('/test-series', [CourseApiController::class, 'testSeries']);
    Route::post('/exam_wise_course', [CourseApiController::class, 'exam_wise_course']);
    Route::post('/letures', [CourseApiController::class, 'lectures']);

    Route::post('/mycourses', [CourseApiController::class, 'myCourses']);
    Route::post('/mytestseries', [CourseApiController::class, 'myTestSeries']);
    Route::post('/free-course', [CourseApiController::class, 'freeCourse']);
    Route::post('/free-testseries', [CourseApiController::class, 'freeTestSeries']);


    Route::post('/save-quiz-attempt', [QuizController::class, 'saveQuizAttempt']);
    Route::post('/quiz-attempted-result', [QuizController::class, 'quizAttemptedResult']);



    Route::post('/create-order', [PaymentController::class, 'createOrder']);
    Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']);
    Route::post('/payment-failed', [PaymentController::class, 'paymentFailed']);
});
