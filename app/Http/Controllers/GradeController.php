<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Grade;
use App\Support\DataScope;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GradeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    /**
     * Display grades according to the authenticated user's role.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = DataScope::grades($user)
            ->with([
                'enrollment.student',
                'enrollment.section.course',
                'enrollment.section.semester',
                'reviewer',
                'approver',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search, $user) {

                if ($user->role !== 'student') {
                    $query->whereHas('enrollment.student', function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }

                $query->orWhereHas(
                    'enrollment.section.course',
                    function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    }
                );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $query->when(
            $request->filled('course_id'),
            fn($query) => $query->whereHas(
                'enrollment.section',
                fn($query) => $query->where(
                    'course_id',
                    $request->input('course_id')
                )
            )
        );

        $query->when(
            $request->filled('semester_id'),
            fn($query) => $query->whereHas(
                'enrollment.section',
                fn($query) => $query->where(
                    'semester_id',
                    $request->input('semester_id')
                )
            )
        );

        if ($user->role !== 'student') {
            $query->when(
                $request->filled('status'),
                fn($query) => $query->where(
                    'status',
                    $request->input('status')
                )
            );
        }

        $grades = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $courses = DataScope::courses($user)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        $semesters = DataScope::semesters($user)
            ->orderByDesc('start_date')
            ->get(['id', 'name', 'code']);

        return $request->expectsJson()
            ? response()->json($grades)
            : view('grades.index', compact(
                'grades',
                'courses',
                'semesters'
            ));
    }

    /**
     * Display a single grade.
     */
    public function show(Request $request, Grade $grade)
    {
        $user = $request->user();
        DataScope::ensureVisible($user, $grade);

        $grade->load([
            'enrollment.student',
            'enrollment.section.course',
            'enrollment.section.semester',
            'reviewer',
            'approver',
        ]);



        /*
        |--------------------------------------------------------------------------
        | Student Access
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'student') {
            abort_unless(
                $grade->enrollment?->student_id === $user->id
                    && $grade->status === 'published',
                403
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Instructor Access
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'instructor') {
            abort_unless(
                $grade->enrollment?->section?->instructor_id === $user->id,
                403
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Employee / Admin
        |--------------------------------------------------------------------------
        |
        | Employees and admins may view grades for workflow processing.
        |
        */

        abort_unless(
            in_array($user->role, [
                'admin',
                'instructor',
                'employee',
                'student',
            ]),
            403
        );

        return $request->expectsJson()
            ? response()->json($grade)
            : view('grades.show', compact('grade'));
    }

    /**
     * Show rejection form.
     */
    public function rejectForm(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'employee',
            403
        );
        DataScope::ensureVisible($user, $grade);

        abort_unless(
            in_array($grade->status, ['submitted', 'reviewed']),
            422,
            'This grade cannot be rejected in its current status.'
        );

        $grade->load([
            'enrollment.student',
            'enrollment.section.course',
            'enrollment.section.semester',
        ]);

        return view('grades.reject', compact('grade'));
    }


    /**
     * Show create form.
     */
    public function create(Request $request)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['admin', 'instructor']),
            403
        );

        $query = DataScope::enrollments($user)
            ->with([
                'student',
                'section.course',
                'section.semester',
            ])
            ->whereDoesntHave('grade');

        $enrollments = $query->get();

        return view('grades.create', compact('enrollments'));
    }

    /**
     * Store a new grade.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['admin', 'instructor']),
            403
        );

        $validated = $request->validate([
            'enrollment_id' => ['required', 'exists:enrollments,id', 'unique:grades,enrollment_id'],
            'practical_grade' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],
            'theoretical_grade' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],
        ]);

        $enrollment = DataScope::enrollments($user)
            ->with('section')
            ->findOrFail($validated['enrollment_id']);

        $grade = Grade::create([
            'enrollment_id' => $enrollment->id,
            'practical_grade' => $validated['practical_grade'] ?? null,
            'theoretical_grade' => $validated['theoretical_grade'] ?? null,
            'status' => 'draft',
        ]);

        if (! $request->expectsJson()) {
            return redirect()
                ->route('grades.index')
                ->with('success', __('Grade created successfully.'));
        }

        return response()->json([
            'message' => __('Grade created successfully.'),
            'data' => $grade->load([
                'enrollment.student',
                'enrollment.section.course',
                'enrollment.section.semester',
            ]),
        ], 201);
    }

    /**
     * Show edit form.
     */
    public function edit(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['admin', 'instructor']),
            403
        );
        DataScope::ensureVisible($user, $grade);

        $grade->load([
            'enrollment.student',
            'enrollment.section.course',
            'enrollment.section.semester',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Only Draft / Rejected Grades Can Be Edited
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array($grade->status, ['draft', 'rejected']),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Instructor Ownership
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'instructor') {
            abort_unless(
                $grade->enrollment?->section?->instructor_id === $user->id,
                403
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Enrollment List
        |--------------------------------------------------------------------------
        */

        $query = Enrollment::query()
            ->with([
                'student',
                'section.course',
                'section.semester',
            ])
            ->where(function ($query) use ($grade) {
                $query
                    ->whereDoesntHave('grade')
                    ->orWhere('id', $grade->enrollment_id);
            });

        $query->whereIn(
            'enrollments.id',
            DataScope::enrollments($user)->select('enrollments.id')
        );

        $enrollments = $query->get();

        return view('grades.edit', compact(
            'grade',
            'enrollments'
        ));
    }

    /**
     * Update grade values.
     */
    public function update(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['admin', 'instructor']),
            403
        );
        DataScope::ensureVisible($user, $grade);

        $grade->load('enrollment.section');

        /*
        |--------------------------------------------------------------------------
        | Only Draft / Rejected Grades Can Be Edited
        |--------------------------------------------------------------------------
        */

        abort_unless(
            in_array($grade->status, ['draft', 'rejected']),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Instructor Ownership
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'instructor') {
            abort_unless(
                $grade->enrollment?->section?->instructor_id === $user->id,
                403
            );
        }

        $validated = $request->validate([
            'practical_grade' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],
            'theoretical_grade' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Rejected → Draft
        |--------------------------------------------------------------------------
        |
        | Once the instructor edits a rejected grade, it becomes a draft again.
        |
        */

        $grade->update([
            'practical_grade' => $validated['practical_grade'] ?? null,
            'theoretical_grade' => $validated['theoretical_grade'] ?? null,
            'status' => 'draft',
            'rejection_reason' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
            'approved_by' => null,
            'approved_at' => null,
            'published_at' => null,
        ]);

        if (! $request->expectsJson()) {
            return redirect()
                ->route('grades.show', $grade)
                ->with('success', __('Grade updated successfully.'));
        }

        return response()->json([
            'message' => __('Grade updated successfully.'),
            'data' => $grade->load([
                'enrollment.student',
                'enrollment.section.course',
                'enrollment.section.semester',
            ]),
        ]);
    }

    /**
     * Instructor submits grade for employee review.
     */
    public function submit(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'instructor',
            403
        );
        DataScope::ensureVisible($user, $grade);

        $grade->load('enrollment.section');

        abort_unless(
            $grade->enrollment?->section?->instructor_id === $user->id,
            403
        );

        abort_unless(
            in_array($grade->status, ['draft', 'rejected']),
            422,
            'Only draft or rejected grades can be submitted.'
        );

        abort_unless(
            $grade->practical_grade !== null
                && $grade->theoretical_grade !== null,
            422,
            'Both practical and theoretical grades are required.'
        );

        $grade->update([
            'status' => 'submitted',
            'rejection_reason' => null,
        ]);

        return $request->expectsJson()
            ? response()->json([
                'message' => __('Grade submitted for review successfully.'),
                'data' => $grade,
            ])
            : redirect()
            ->route('grades.show', $grade)
            ->with('success', __('Grade submitted for review successfully.'));
    }

    /**
     * Employee reviews a submitted grade.
     */
    public function review(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'employee',
            403
        );
        DataScope::ensureVisible($user, $grade);

        abort_unless(
            $grade->status === 'submitted',
            422,
            'Only submitted grades can be reviewed.'
        );

        $grade->update([
            'status' => 'reviewed',
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
            'rejection_reason' => null,
        ]);

        return $request->expectsJson()
            ? response()->json([
                'message' => __('Grade reviewed successfully.'),
                'data' => $grade,
            ])
            : redirect()
            ->route('grades.show', $grade)
            ->with('success', __('Grade reviewed successfully.'));
    }

    /**
     * Employee rejects a submitted grade.
     */
    public function reject(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'employee',
            403
        );
        DataScope::ensureVisible($user, $grade);

        abort_unless(
            in_array($grade->status, ['submitted', 'reviewed']),
            422,
            'This grade cannot be rejected in its current status.'
        );

        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ]);

        $grade->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => $user->id,
            'reviewed_at' => now(),
            'approved_by' => null,
            'approved_at' => null,
            'published_at' => null,
        ]);

        return $request->expectsJson()
            ? response()->json([
                'message' => __('Grade rejected successfully.'),
                'data' => $grade,
            ])
            : redirect()
            ->route('grades.show', $grade)
            ->with('success', __('Grade rejected successfully.'));
    }

    /**
     * Admin approves a reviewed grade.
     */
    public function approve(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'admin',
            403
        );
        DataScope::ensureVisible($user, $grade);

        abort_unless(
            $grade->status === 'reviewed',
            422,
            'Only reviewed grades can be approved.'
        );

        $grade->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);

        return $request->expectsJson()
            ? response()->json([
                'message' => __('Grade approved successfully.'),
                'data' => $grade,
            ])
            : redirect()
            ->route('grades.show', $grade)
            ->with('success', __('Grade approved successfully.'));
    }

    /**
     * Admin publishes an approved grade.
     */
    public function publish(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'admin',
            403
        );
        DataScope::ensureVisible($user, $grade);

        abort_unless(
            $grade->status === 'approved',
            422,
            'Only approved grades can be published.'
        );

        $grade->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return $request->expectsJson()
            ? response()->json([
                'message' => __('Grade published successfully.'),
                'data' => $grade,
            ])
            : redirect()
            ->route('grades.show', $grade)
            ->with('success', __('Grade published successfully.'));
    }

    /**
     * Delete a grade.
     *
     * Deletion is allowed only while the grade is still a draft.
     */
    public function destroy(Request $request, Grade $grade)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['admin', 'instructor']),
            403
        );
        DataScope::ensureVisible($user, $grade);

        $grade->load('enrollment.section');

        abort_unless(
            $grade->status === 'draft',
            403
        );

        if ($user->role === 'instructor') {
            abort_unless(
                $grade->enrollment?->section?->instructor_id === $user->id,
                403
            );
        }

        $grade->delete();

        return $request->expectsJson()
            ? response()->json([
                'message' => __('Grade deleted successfully.'),
            ])
            : redirect()
            ->route('grades.index')
            ->with('success', __('Grade deleted successfully.'));
    }
}
