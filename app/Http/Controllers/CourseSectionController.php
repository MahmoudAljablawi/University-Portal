<?php

namespace App\Http\Controllers;

use App\Models\AcademicSemester;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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
    public function index()
    {
        $sections = CourseSection::with(['course', 'semester', 'instructor'])->get();
        return response()->json($sections);
        //return view('course-sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$courses = Course::all();
        //$semesters = AcademicSemester::all();
        //$instructors = User::where('role', 'instructor')->get();

        //return view('course-sections.create', compact('courses', 'semesters', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'semester_id' => 'required|exists:academic_semesters,id',
            'instructor_id' => 'required|exists:users,id|role:instructor',
            'section_number' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
        ]);

        $section = CourseSection::create($validated);

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
        return response()->json($crsSec);
        //return view('course-sections.show', compact('crsSec'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseSection $courseSection)
    {
        //$courses = Course::all();
        //$semesters = AcademicSemester::all();
        //$instructors = User::where('role', 'instructor')->get();

        //return view('course-sections.edit', compact('courseSection', 'courses', 'semesters', 'instructors'));
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

        return response()->json([
            'message' => 'Course Section Deleted Successfully'
        ]);
        //return redirect()->route('course-sections.index')->with('success', 'Course section deleted successfully.');
    }
}
