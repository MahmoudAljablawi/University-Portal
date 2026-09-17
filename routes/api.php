<?php

use Illuminate\Http\Request;
//use App\Http\Controllers\CollegeController;
//use App\Http\Controllers\DepartmentController;
//use App\Http\Controllers\AcademicSemesterController;
//use App\Http\Controllers\CourseController;
//use App\Http\Controllers\CourseSectionController;
//use App\Http\Controllers\EnrollmentController;
//use App\Http\Controllers\GradeController;
//use App\Http\Controllers\AcademicRequestController;
//use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
//use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::apiResource('colleges', CollegeController::class);
//Route::apiResource('departments', DepartmentController::class);
//Route::apiResource('academic-semesters', AcademicSemesterController::class);
//Route::apiResource('courses', CourseController::class);
//Route::apiResource('course-sections', CourseSectionController::class);
//Route::apiResource('enrollments', EnrollmentController::class);
//Route::apiResource('grades', GradeController::class);
//Route::apiResource('academic-requests', AcademicRequestController::class);
//Route::apiResource('audit-logs', AuditLogController::class);
//Route::apiResource('users', UserController::class);

//   للمتطلبات السابقة للمقررات
//Route::post('courses/{course}/prerequisites', [CourseController::class, 'addPrerequisite']);
//Route::delete('courses/{course}/prerequisites', [CourseController::class, 'removePrerequisite']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
