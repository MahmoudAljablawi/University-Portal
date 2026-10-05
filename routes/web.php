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
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('colleges', CollegeController::class);

    Route::resource('departments', DepartmentController::class);

    Route::resource(
        'academic-semesters',
        AcademicSemesterController::class
    );

    Route::resource('courses', CourseController::class);

    Route::resource(
        'course-sections',
        CourseSectionController::class
    );

    Route::resource('enrollments', EnrollmentController::class);

    Route::resource('grades', GradeController::class);
    Route::post('grades/{grade}/submit', [GradeController::class, 'submit'])
        ->name('grades.submit');

    Route::post('grades/{grade}/review', [GradeController::class, 'review'])
        ->name('grades.review');

    Route::post('grades/{grade}/approve', [GradeController::class, 'approve'])
        ->name('grades.approve');

    Route::post('grades/{grade}/reject', [GradeController::class, 'reject'])
        ->name('grades.reject');

    Route::get('grades/{grade}/reject', [GradeController::class, 'rejectForm'])
        ->name('grades.reject.form');

    Route::post('grades/{grade}/publish', [GradeController::class, 'publish'])
        ->name('grades.publish');

    Route::resource(
        'academic-requests',
        AcademicRequestController::class
    );


    Route::post(
        'academic-requests/{academicRequest}/approve',
        [AcademicRequestController::class, 'approve']
    )->name('academic-requests.approve');

    Route::post(
        'academic-requests/{academicRequest}/reject',
        [AcademicRequestController::class, 'reject']
    )->name('academic-requests.reject');

    Route::resource('audit-logs', AuditLogController::class)
        ->only(['index', 'show']);

    Route::resource('users', UserController::class);

    /*
    |--------------------------------------------------------------------------
    | Course Prerequisites
    |--------------------------------------------------------------------------
    */

    Route::post(
        'courses/{course}/prerequisites',
        [CourseController::class, 'addPrerequisite']
    );

    Route::delete(
        'courses/{course}/prerequisites',
        [CourseController::class, 'removePrerequisite']
    );
});

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
*/

Route::get('/language/{locale}', function (string $locale) {

    abort_unless(
        in_array($locale, ['en', 'ar']),
        404
    );

    session(['locale' => $locale]);

    return redirect()->back();
})->name('language.switch');
