<?php

namespace App\Http\Controllers;

use App\Models\AcademicRequest;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Grade;
use App\Models\User;
use App\Support\DataScope;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $stats = match ($user->role) {
            'admin' => $this->adminStats(),
            'instructor' => $this->instructorStats($user),
            'student' => $this->studentStats($user),
            'employee' => $this->employeeStats($user),
            default => [],
        };

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

            'requests' => AcademicRequest::where('status', 'pending')
                ->count(),

            'pending_grade_approvals' => Grade::where('status', 'reviewed')
                ->count(),

            'approved_grades' => Grade::where('status', 'approved')
                ->count(),

            'published_grades' => Grade::where('status', 'published')
                ->count(),
        ];
    }

    /**
     * Instructor dashboard statistics.
     */
    private function instructorStats(User $user): array
    {
        $sectionIds = DataScope::courseSections($user)
            ->pluck('id');

        $studentCount = DataScope::enrollments($user)
            ->distinct('student_id')
            ->count('student_id');

        $draftGrades = DataScope::grades($user)
            ->where('status', 'draft')
            ->count();

        $rejectedGrades = DataScope::grades($user)
            ->where('status', 'rejected')
            ->count();

        $submittedGrades = DataScope::grades($user)
            ->where('status', 'submitted')
            ->count();

        return [
            'sections' => $sectionIds->count(),

            'students' => $studentCount,

            'pending_grades' => $draftGrades + $rejectedGrades,

            'draft_grades' => $draftGrades,

            'rejected_grades' => $rejectedGrades,

            'submitted_grades' => $submittedGrades,
        ];
    }

    /**
     * Student dashboard statistics.
     */
    private function studentStats(User $user): array
    {
        return [
            'courses' => DataScope::enrollments($user)
                ->where('status', 'enrolled')
                ->count(),

            'grades' => DataScope::grades($user)
                ->count(),

            'requests' => DataScope::academicRequests($user)
                ->where('status', 'pending')
                ->count(),
        ];
    }

    /**
     * Employee dashboard statistics.
     */
    private function employeeStats(User $user): array
    {
        return [
            'pending_grade_reviews' => DataScope::grades($user)
                ->where('status', 'submitted')
                ->count(),

            'requests' => DataScope::academicRequests($user)
                ->where('status', 'pending')
                ->count(),

            'completed_reviews' => DataScope::grades($user)
                ->where('status', 'reviewed')
                ->count(),
        ];
    }
}
