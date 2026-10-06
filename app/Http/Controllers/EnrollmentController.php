<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Support\DataScope;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

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

        $query = DataScope::enrollments($user)
            ->with([
                'student',
                'section.course',
                'section.semester',
            ]);

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


        $courses = DataScope::courses($user)->orderBy('name')
            ->get(['id', 'name', 'code']);

        $semesters = DataScope::semesters($user)->orderByDesc('start_date')
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
        $user = request()->user();
        $students = DataScope::users($user)->where('role', 'student')->get();
        $sections = DataScope::courseSections($user)->with(['course', 'semester'])->get();
        return view('enrollments.create', compact('students', 'sections'));
    }
    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'section_id' => 'required|exists:course_sections,id',
            'student_id' => $user->role === 'admin'
                ? ['required', Rule::exists('users', 'id')->where('role', 'student')]
                : 'prohibited',
        ]);

        abort_unless(
            DataScope::courseSections($user)->whereKey($validated['section_id'])->exists(),
            404
        );

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
                'message' => __('Student is already enrolled in this section.')
            ], 422);
        }

        $enrollment = Enrollment::create([
            'student_id' => $studentId,
            'section_id' => $validated['section_id'],
            'status' => 'enrolled',
        ]);

        if (! $request->expectsJson()) {
            return redirect()->route('enrollments.index')->with('success', __('Student enrolled successfully.'));
        }
        return response()->json([
            'message' => __('Enrollment Created Successfully'),
            'data' => $enrollment->load(['section.course', 'student'])
        ], 201);
        //return redirect()->route('enrollments.index')->with('success', __('Student enrolled successfully.'));
    }

    public function show(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();
        DataScope::ensureVisible($user, $enrollment);

        return $request->expectsJson()
            ? response()->json($enrollment->load(['student', 'section.course']))
            : view('enrollments.show', compact('enrollment'));
    }

    public function edit(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();
        DataScope::ensureVisible($user, $enrollment);
        $students = DataScope::users($user)->where('role', 'student')->get();
        $sections = DataScope::courseSections($user)->with(['course', 'semester'])->get();
        return view('enrollments.edit', compact('enrollment', 'students', 'sections'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();
        DataScope::ensureVisible($user, $enrollment);

        $validated = $request->validate([
            'student_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'student'),
            ],
            'section_id' => [
                'required',
                'exists:course_sections,id',
                function ($attribute, $value, $fail) use ($user) {
                    if (! DataScope::courseSections($user)->whereKey($value)->exists()) {
                        $fail(__('The selected section is outside your data scope.'));
                    }
                },
            ],
            'status' => 'required|string|in:enrolled,dropped,passed,failed',
        ]);

        if ($user->role !== 'admin') {
            abort_unless((int) $validated['student_id'] === $enrollment->student_id, 403);
        }

        $enrollment->update($validated);

        return redirect()->route('enrollments.index')
            ->with('success', __('Enrollment updated successfully.'));
    }

    public function destroy(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();
        DataScope::ensureVisible($user, $enrollment);
        abort_unless(
            $user->role === 'admin' ||
                ($user->role === 'student' && $enrollment->student_id === $user->id),
            403
        );

        $enrollment->delete();

        if (! $request->expectsJson()) {
            return redirect()->route('enrollments.index')->with('success', __('Enrollment deleted successfully.'));
        }
        return response()->json([
            'message' => __('Enrollment Dropped Successfully')
        ]);
        //return redirect()->route('enrollments.index')->with('success', __('Enrollment deleted successfully.'));
    }
}
