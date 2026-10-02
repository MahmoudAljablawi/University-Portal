<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\CourseSection;
use App\Models\AcademicSemester;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EnrollmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function index(Request $request)
    {
        $user = $request->user();


        $query = Enrollment::query()
            ->with([
                'student',
                'section.course',
                'section.semester',
            ]);


        if ($user->role === 'instructor') {
            $query->whereHas('section', function ($query) use ($user) {
                $query->where('instructor_id', $user->id);
            });
        } elseif ($user->role === 'student') {
            $query->where('student_id', $user->id);
        }



        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search, $user) {

                if ($user->role !== 'student') {
                    $query->whereHas('student', function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }

                $query->orWhereHas('section.course', function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            });
        }

   

        $query->when(
            $request->filled('course_id'),
            fn($query) => $query->whereHas(
                'section',
                fn($query) => $query->where('course_id', $request->input('course_id'))
            )
        );

        $query->when(
            $request->filled('semester_id'),
            fn($query) => $query->whereHas(
                'section',
                fn($query) => $query->where('semester_id', $request->input('semester_id'))
            )
        );

        $query->when(
            $request->filled('status'),
            fn($query) => $query->where(
                'status',
                $request->input('status')
            )
        );

 

        $enrollments = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();


        $courses = Course::orderBy('name')
            ->get(['id', 'name', 'code']);

        $semesters = AcademicSemester::orderByDesc('start_date')
            ->get(['id', 'name', 'code']);

        return $request->expectsJson()
            ? response()->json($enrollments)
            : view('enrollments.index', compact(
                'enrollments',
                'courses',
                'semesters'
            ));
    }


    public function create()
    {
        $students = User::where('role', 'student')->get();
        $sections = CourseSection::with(['course', 'semester'])->get();
        return view('enrollments.create', compact('students', 'sections'));
    }
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'section_id' => 'required|exists:course_sections,id',
            'student_id' => $user->role === 'admin' ? 'required|exists:users,id' : 'prohibited',
        ]);

        $studentId = $user->role === 'admin' ? $validated['student_id'] : $user->id;

        // التحقق من عدم التكرار في نفس الشعبة
        $exists = Enrollment::where('student_id', $studentId)
            ->where('section_id', $validated['section_id'])
            ->exists();

        if ($exists) {
            if (! $request->expectsJson()) {
                return back()->withErrors(['section_id' => 'Student is already enrolled in this section.']);
            }
            return response()->json([
                'message' => 'Student is already enrolled in this section.'
            ], 422);
        }

        $enrollment = Enrollment::create([
            'student_id' => $studentId,
            'section_id' => $validated['section_id'],
            'status' => 'enrolled',
        ]);

        if (! $request->expectsJson()) {
            return redirect()->route('enrollments.index')->with('success', 'Student enrolled successfully.');
        }
        return response()->json([
            'message' => 'Enrollment Created Successfully',
            'data' => $enrollment->load(['section.course', 'student'])
        ], 201);
        //return redirect()->route('enrollments.index')->with('success', 'Student enrolled successfully.');
    }

    public function show(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $user->id !== $enrollment->student_id) {
            abort_unless($request->expectsJson(), 403);
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $request->expectsJson()
            ? response()->json($enrollment->load(['student', 'section.course']))
            : view('enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment)
    {
        $students = User::where('role', 'student')->get();
        $sections = CourseSection::with(['course', 'semester'])->get();
        return view('enrollments.edit', compact('enrollment', 'students', 'sections'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'section_id' => 'required|exists:course_sections,id',
            'status' => 'required|string|in:enrolled,dropped,completed',
        ]);

        $enrollment->update($validated);

        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment updated successfully.');
    }

    public function destroy(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $user->id !== $enrollment->student_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $enrollment->delete();

        if (! $request->expectsJson()) {
            return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully.');
        }
        return response()->json([
            'message' => 'Enrollment Dropped Successfully'
        ]);
        //return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully.');
    }
}
