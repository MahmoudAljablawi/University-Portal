<?php

namespace App\Http\Controllers;

use App\Models\CourseSection;
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
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseSection $courseSection)
    {
        return response()->json($courseSection->load(['course', 'semester', 'instructor', 'enrollments.student']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    }
}
