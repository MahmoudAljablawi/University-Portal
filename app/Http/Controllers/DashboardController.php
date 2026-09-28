<?php

namespace App\Http\Controllers;

use App\Models\AcademicRequest;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $stats = [];

        switch ($user->role) {
            case 'admin':
                $stats = $this->adminStats();

                break;

            case 'instructor':
                $stats = $this->instructorStats($user->id);

                break;

            case 'student':
                $stats = $this->studentStats($user->id);

                break;

            case 'employee':
                $stats = $this->employeeStats();

                break;
        }

        return view('dashboard', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }

    /**
     * Administrator dashboard statistics.
     */
    private function adminStats(): array
    {
        return [
            'users' => User::count(),

            'courses' => Course::count(),

            'sections' => CourseSection::count(),

            'requests' => AcademicRequest::where('status', 'pending')->count(),
        ];
    }

    /**
     * Instructor dashboard statistics.
     */
    private function instructorStats(int $instructorId): array
    {
        $sectionIds = CourseSection::where('instructor_id', $instructorId)
            ->pluck('id');

        $studentCount = Enrollment::whereIn('section_id', $sectionIds)
            ->distinct('student_id')
            ->count('student_id');

        $pendingGrades = Grade::whereHas('enrollment', function ($query) use ($sectionIds) {
            $query->whereIn('section_id', $sectionIds);
        })
            ->where('is_published', false)
            ->count();

        return [
            'sections' => $sectionIds->count(),

            'students' => $studentCount,

            'pending_grades' => $pendingGrades,
        ];
    }

    /**
     * Student dashboard statistics.
     */
    private function studentStats(int $studentId): array
    {
        return [
            'courses' => Enrollment::where('student_id', $studentId)
                ->where('status', 'enrolled')
                ->count(),

            'grades' => Grade::whereHas('enrollment', function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            })
                ->where('is_published', true)
                ->count(),

            'requests' => AcademicRequest::where('student_id', $studentId)
                ->where('status', 'pending')
                ->count(),
        ];
    }

    /**
     * Employee dashboard statistics.
     *
     * Employee functionality is not fully represented
     * in the current backend, so keep this section safe
     * until its workflow is implemented.
     */
    private function employeeStats(): array
    {
        return [
            'pending_grade_reviews' => 0,

            'requests' => AcademicRequest::where('status', 'pending')->count(),

            'completed_reviews' => 0,
        ];
    }
}
