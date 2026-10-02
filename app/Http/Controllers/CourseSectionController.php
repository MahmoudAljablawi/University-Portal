<?php

namespace App\Http\Controllers;

use App\Models\AcademicSemester;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;

class CourseSectionController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:admin', except: ['index', 'show']),
        ];
    }
    public function index(Request $request)
    {
        $query = CourseSection::with([
            'course',
            'semester',
            'instructor',
        ]);


        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(
                'section_number',
                'like',
                "%{$search}%"
            );
        }

        $query->when(
            $request->filled('course_id'),
            fn($query) => $query->where(
                'course_id',
                $request->input('course_id')
            )
        );

        $query->when(
            $request->filled('semester_id'),
            fn($query) => $query->where(
                'semester_id',
                $request->input('semester_id')
            )
        );

        $query->when(
            $request->filled('instructor_id'),
            fn($query) => $query->where(
                'instructor_id',
                $request->input('instructor_id')
            )
        );

        $sections = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $courses = Course::orderBy('name')->get(['id', 'name']);
        $semesters = AcademicSemester::orderByDesc('start_date')
            ->get(['id', 'name']);
        $instructors = User::where('role', 'instructor')
            ->orderBy('name')
            ->get(['id', 'name']);

        return $request->expectsJson()
            ? response()->json($sections)
            : view('course-sections.index', compact(
                'sections',
                'courses',
                'semesters',
                'instructors'
            ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $semesters = AcademicSemester::all();
        $instructors = User::where('role', 'instructor')->get();
        return view('course-sections.create', compact('courses', 'semesters', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'semester_id' => 'required|exists:academic_semesters,id',
            'instructor_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'instructor');
                }),
            ],
            'section_number' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
        ]);

        $section = CourseSection::create($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('course-sections.index')->with('success', 'Course section created successfully.');
        }
        return response()->json([
            'message' => 'Course Section Created Successfully',
            'data' => $section->load(['course', 'semester', 'instructor'])
        ], 201);
        //return redirect()->route('course-sections.index')->with('success', 'Course section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseSection $courseSection)
    {
        $crsSec = $courseSection->load(['course', 'semester', 'instructor', 'enrollments.student']);
        return request()->expectsJson() ? response()->json($crsSec) : view('course-sections.show', compact('crsSec'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseSection $courseSection)
    {
        $courses = Course::all();
        $semesters = AcademicSemester::all();
        $instructors = User::where('role', 'instructor')->get();
        return view('course-sections.edit', compact('courseSection', 'courses', 'semesters', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseSection $courseSection)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'semester_id' => 'required|exists:academic_semesters,id',
            'instructor_id' => 'required|exists:users,id',
            'section_number' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
        ]);

        $courseSection->update($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('course-sections.index')->with('success', 'Course section updated successfully.');
        }
        return response()->json([
            'message' => 'Data Of Course Section Updated Successfully',
            'data' => $courseSection->load(['course', 'semester', 'instructor'])
        ]);
        //return redirect()->route('course-sections.index')->with('success', 'Course section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseSection $courseSection)
    {
        $courseSection->delete();

        if (! request()->expectsJson()) {
            return redirect()->route('course-sections.index')->with('success', 'Course section deleted successfully.');
        }
        return response()->json([
            'message' => 'Course Section Deleted Successfully'
        ]);
        //return redirect()->route('course-sections.index')->with('success', 'Course section deleted successfully.');
    }
}
