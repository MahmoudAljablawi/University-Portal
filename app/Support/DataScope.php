<?php

namespace App\Support;

use App\Models\AcademicRequest;
use App\Models\AcademicSemester;
use App\Models\College;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DataScope
{
    public static function colleges(User $user): Builder
    {
        $query = College::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            return $user->college_id
                ? $query->whereKey($user->college_id)
                : $query->whereRaw('1 = 0');
        }

        if ($user->role === 'instructor') {
            return $query->whereHas(
                'departments.courses.sections',
                fn (Builder $sections) => $sections->where('instructor_id', $user->id)
            );
        }

        if ($user->role === 'student') {
            return $query;
        }

        return $query->whereRaw('1 = 0');
    }

    public static function departments(User $user): Builder
    {
        $query = Department::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            return $user->college_id
                ? $query->where('college_id', $user->college_id)
                : $query->whereRaw('1 = 0');
        }

        if ($user->role === 'instructor') {
            return $query->whereHas(
                'courses.sections',
                fn (Builder $sections) => $sections->where('instructor_id', $user->id)
            );
        }

        if ($user->role === 'student') {
            return $query;
        }

        return $query->whereRaw('1 = 0');
    }

    public static function courses(User $user): Builder
    {
        $query = Course::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            return $user->college_id
                ? $query->whereHas(
                    'department',
                    fn (Builder $departments) => $departments->where('college_id', $user->college_id)
                )
                : $query->whereRaw('1 = 0');
        }

        if ($user->role === 'instructor') {
            return $query->whereHas(
                'sections',
                fn (Builder $sections) => $sections->where('instructor_id', $user->id)
            );
        }

        if ($user->role === 'student') {
            return $query;
        }

        return $query->whereRaw('1 = 0');
    }

    public static function courseSections(User $user): Builder
    {
        $query = CourseSection::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            return $user->college_id
                ? $query->whereHas(
                    'course.department',
                    fn (Builder $departments) => $departments->where('college_id', $user->college_id)
                )
                : $query->whereRaw('1 = 0');
        }

        if ($user->role === 'instructor') {
            return $query->where('instructor_id', $user->id);
        }

        if ($user->role === 'student') {
            // Students need the course catalog to find sections before their first enrollment.
            return $query;
        }

        return $query->whereRaw('1 = 0');
    }

    public static function enrollments(User $user): Builder
    {
        $query = Enrollment::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            return $user->college_id
                ? $query->whereHas(
                    'section.course.department',
                    fn (Builder $departments) => $departments->where('college_id', $user->college_id)
                )
                : $query->whereRaw('1 = 0');
        }

        if ($user->role === 'instructor') {
            return $query->whereHas(
                'section',
                fn (Builder $sections) => $sections->where('instructor_id', $user->id)
            );
        }

        if ($user->role === 'student') {
            return $query->where('student_id', $user->id);
        }

        return $query->whereRaw('1 = 0');
    }

    public static function grades(User $user): Builder
    {
        $query = Grade::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            return $user->college_id
                ? $query->whereHas(
                    'enrollment.section.course.department',
                    fn (Builder $departments) => $departments->where('college_id', $user->college_id)
                )
                : $query->whereRaw('1 = 0');
        }

        if ($user->role === 'instructor') {
            return $query->whereHas(
                'enrollment.section',
                fn (Builder $sections) => $sections->where('instructor_id', $user->id)
            );
        }

        if ($user->role === 'student') {
            return $query->whereHas(
                'enrollment',
                fn (Builder $enrollments) => $enrollments->where('student_id', $user->id)
            )->where('status', 'published');
        }

        return $query->whereRaw('1 = 0');
    }

    public static function academicRequests(User $user): Builder
    {
        $query = AcademicRequest::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            return $user->college_id
                ? $query->whereHas(
                    'student.enrollments.section.course.department',
                    fn (Builder $departments) => $departments->where('college_id', $user->college_id)
                )
                : $query->whereRaw('1 = 0');
        }

        if ($user->role === 'student') {
            return $query->where('student_id', $user->id);
        }

        return $query->whereRaw('1 = 0');
    }

    public static function semesters(User $user): Builder
    {
        $query = AcademicSemester::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            return $user->college_id
                ? $query->whereHas(
                    'courseSections.course.department',
                    fn (Builder $departments) => $departments->where('college_id', $user->college_id)
                )
                : $query->whereRaw('1 = 0');
        }

        if ($user->role === 'instructor') {
            return $query->whereHas(
                'courseSections',
                fn (Builder $sections) => $sections->where('instructor_id', $user->id)
            );
        }

        if ($user->role === 'student') {
            return $query;
        }

        return $query->whereRaw('1 = 0');
    }

    public static function users(User $user): Builder
    {
        $query = User::query();

        if ($user->role === 'admin') {
            return $query;
        }

        if ($user->role === 'employee') {
            if (! $user->college_id) {
                return $query->whereRaw('1 = 0');
            }

            return $query->where(function (Builder $users) use ($user) {
                $users->where(function (Builder $employees) use ($user) {
                    $employees->where('role', 'employee')
                        ->where('college_id', $user->college_id);
                })->orWhere(function (Builder $instructors) use ($user) {
                    $instructors->where('role', 'instructor')
                        ->whereHas(
                            'teachingSections.course.department',
                            fn (Builder $departments) => $departments->where('college_id', $user->college_id)
                        );
                })->orWhere(function (Builder $students) use ($user) {
                    $students->where('role', 'student')
                        ->whereHas(
                            'enrollments.section.course.department',
                            fn (Builder $departments) => $departments->where('college_id', $user->college_id)
                        );
                });
            });
        }

        if ($user->role === 'instructor') {
            return $query->whereKey($user->id);
        }

        if ($user->role === 'student') {
            return $query->whereKey($user->id);
        }

        return $query->whereRaw('1 = 0');
    }

    public static function ensureVisible(User $user, Model $record): void
    {
        $query = match (true) {
            $record instanceof AcademicRequest => self::academicRequests($user),
            $record instanceof AcademicSemester => self::semesters($user),
            $record instanceof College => self::colleges($user),
            $record instanceof Course => self::courses($user),
            $record instanceof CourseSection => self::courseSections($user),
            $record instanceof Department => self::departments($user),
            $record instanceof Enrollment => self::enrollments($user),
            $record instanceof Grade => self::grades($user),
            $record instanceof User => self::users($user),
            default => abort(500, 'No data scope is defined for this record type.'),
        };

        abort_unless(
            $query->whereKey($record->getKey())->exists(),
            404
        );
    }
}
