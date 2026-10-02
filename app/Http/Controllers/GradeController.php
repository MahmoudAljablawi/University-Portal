<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\CourseSection;
use App\Models\Course;
use App\Models\AcademicSemester;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GradeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:admin,instructor', except: ['index', 'show']),
        ];
    }


    public function index(Request $request)
    {
        $user = $request->user();

        $query = Grade::query()
            ->with([
                'enrollment.student',
                'enrollment.section.course',
                'enrollment.section.semester',
            ]);

 
        if ($user->role === 'instructor') {
            $query->whereHas('enrollment.section', function ($query) use ($user) {
                $query->where('instructor_id', $user->id);
            });
        } elseif ($user->role === 'student') {
            $query->whereHas('enrollment', function ($query) use ($user) {
                $query->where('student_id', $user->id);
            })->where('is_published', true);
        }


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

                $query->orWhereHas('enrollment.section.course', function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            });
        }


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
                    'is_published',
                    $request->input('status') === 'published'
                )
            );
        }

        $grades = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();


        $courses = Course::orderBy('name')
            ->get(['id', 'name', 'code']);

        $semesters = AcademicSemester::orderByDesc('start_date')
            ->get(['id', 'name', 'code']);

        return $request->expectsJson()
            ? response()->json($grades)
            : view('grades.index', compact(
                'grades',
                'courses',
                'semesters'
            ));
    }


    public function show(Request $request, Grade $grade)
    {
        $user = $request->user();

        $grade->load([
            'enrollment.student',
            'enrollment.section.course',
            'enrollment.section.semester',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Student access
    |--------------------------------------------------------------------------
    |
    | A student can only view:
    | 1. Their own grade
    | 2. A published grade
    |
    */

        if ($user->role === 'student') {

            if (
                $grade->enrollment->student_id !== $user->id ||
                ! $grade->is_published
            ) {
                abort_unless($request->expectsJson(), 403);

                return response()->json([
                    'message' => 'Unauthorized',
                ], 403);
            }
        }

        return $request->expectsJson()
            ? response()->json($grade)
            : view('grades.show', compact('grade'));
    }



    public function create()
    {
        $enrollments = Enrollment::with(['student', 'section.course', 'section.semester'])->get();
        return view('grades.create', compact('enrollments'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'midterm_grade' => 'nullable|numeric|min:0|max:100',
            'final_grade' => 'nullable|numeric|min:0|max:100',
            'total_grade' => 'nullable|numeric|min:0|max:100',
            'letter_grade' => 'nullable|string|max:5',
            'is_published' => 'boolean',
        ]);

        // إذا كان المستخدم أستاذ، نتأكد أنه يدرس هذه الشعبة فعلاً
        if ($user->role === 'instructor') {
            $isInstructorOfSection = CourseSection::whereHas('enrollments', fn($q) => $q->whereKey($validated['enrollment_id']))
                ->where('instructor_id', $user->id)
                ->exists();

            if (! $isInstructorOfSection) {
                if (! $request->expectsJson()) {
                    abort(403, 'You are not the instructor for this section.');
                }
                return response()->json(['message' => 'عذراً، لست الأستاذ المسؤول عن هذه الشعبة.'], 403);
            }
        }

        $grade = Grade::updateOrCreate(
            ['enrollment_id' => $validated['enrollment_id']],
            $validated
        );

        if (! $request->expectsJson()) {
            return redirect()->route('grades.index')->with('success', 'Grade recorded successfully.');
        }
        return response()->json([
            'message' => 'Grade Saved Successfully',
            'data' => $grade->load(['student', 'section.course'])
        ], 201);

        //return redirect()->route('grades.index')->with('success', 'Grade recorded successfully.');
    }


    public function edit(Grade $grade)
    {
        $grade->load(['enrollment.student', 'enrollment.section.course', 'enrollment.section.semester']);
        $enrollments = Enrollment::with(['student', 'section.course', 'section.semester'])->get();
        return view('grades.edit', compact('grade', 'enrollments'));
    }

    public function update(Request $request, Grade $grade)
    {
        $user = $request->user();

        if ($user->role === 'instructor') {
            $grade->load('enrollment.section');
            if (optional(optional($grade->enrollment)->section)->instructor_id !== $user->id) {
                abort_unless($request->expectsJson(), 403);
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $validated = $request->validate([
            'midterm_grade' => 'sometimes|nullable|numeric|min:0|max:100',
            'final_grade' => 'sometimes|nullable|numeric|min:0|max:100',
            'total_grade' => 'sometimes|nullable|numeric|min:0|max:100',
            'letter_grade' => 'sometimes|nullable|string|max:5',
            'is_published' => 'sometimes|boolean',
        ]);

        $grade->update($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
        }
        return response()->json([
            'message' => 'Grade Updated Successfully',
            'data' => $grade->load(['enrollment.student', 'enrollment.section.course'])
        ]);
        //return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Request $request, Grade $grade)
    {
        $user = $request->user();

        if ($user->role === 'instructor') {
            $grade->load('enrollment.section');
            if (optional(optional($grade->enrollment)->section)->instructor_id !== $user->id) {
                abort_unless($request->expectsJson(), 403);
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $grade->delete();

        if (! $request->expectsJson()) {
            return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
        }
        return response()->json([
            'message' => 'Grade Deleted Successfully'
        ]);
        //return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}
