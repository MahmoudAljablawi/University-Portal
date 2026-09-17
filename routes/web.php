<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AcademicSemesterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseSectionController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AcademicRequestController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\UserController;

// الصفحة الافتراضية عند بدء تشغيل السيرفر قبل التعديل 
Route::get('/', function () {return view('welcome');});

// الصفحة الرئيسية للوحة التحكم
Route::get('/', function () {return view('dashboard');})->name('dashboard');

// استخدام Route::resource (بدون api) لضمان توفر مسارات create و edit لصفحات Blade
Route::resource('colleges', CollegeController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('academic-semesters', AcademicSemesterController::class);
Route::resource('courses', CourseController::class);
Route::resource('course-sections', CourseSectionController::class);
Route::resource('enrollments', EnrollmentController::class);
Route::resource('grades', GradeController::class);
Route::resource('academic-requests', AcademicRequestController::class);
Route::resource('audit-logs', AuditLogController::class)->only(['index', 'show']);
Route::resource('users', UserController::class);

// مسارات إضافية تابعة للمقررات (المتطلبات السابقة)
Route::post('courses/{course}/prerequisites', [CourseController::class, 'addPrerequisite']);
Route::delete('courses/{course}/prerequisites', [CourseController::class, 'removePrerequisite']);
