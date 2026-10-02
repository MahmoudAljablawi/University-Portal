<?php

namespace App\Providers;

use App\Models\AcademicRequest;
use App\Models\AcademicSemester;
use App\Models\College;
use App\Models\Course;
use App\Models\CoursePrerequisite;
use App\Models\CourseSection;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use App\Observers\AuditLogObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ([
            User::class,
            College::class,
            Department::class,
            AcademicSemester::class,
            Course::class,
            CoursePrerequisite::class,
            CourseSection::class,
            Enrollment::class,
            Grade::class,
            AcademicRequest::class,
        ] as $model) {
            $model::observe(AuditLogObserver::class);
        }
    }
}
