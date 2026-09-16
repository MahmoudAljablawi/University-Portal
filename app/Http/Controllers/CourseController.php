<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CourseController extends Controller implements HasMiddleware
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
        $courses = Course::with(['department', 'prerequisites'])->get();
        return response()->json($courses);
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
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code',
            'department_id' => 'required|exists:departments,id',
            'credits' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $course = Course::create($validated);

        return response()->json([
            'message' => 'Course Created Successfully',
            'data' => $course->load('department')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return response()->json($course->load(['department', 'prerequisites', 'sections']));
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
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'department_id' => 'required|exists:departments,id',
            'credits' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        return response()->json([
            'message' => 'Data Of Course Updated Successfully',
            'data' => $course->load('department')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Course Deleted Successfully'
        ]);
    }
    public function addPrerequisite(Request $request, Course $course)
    {
        $validated = $request->validate([
            'prerequisite_id' => 'required|exists:courses,id|different:id',
        ]);

        // ربط المقرر بالمتطلب السابق عبر جدول الـ Pivot
        $course->prerequisites()->syncWithoutDetaching($validated['prerequisite_id']);

        return response()->json([
            'message' => 'تم إضافة المتطلب السابق بنجاح',
            'data' => $course->load('prerequisites')
        ]);
    }
    public function removePrerequisite(Request $request, Course $course)
    {
        $validated = $request->validate([
            'prerequisite_id' => 'required|exists:courses,id',
        ]);

        $course->prerequisites()->detach($validated['prerequisite_id']);

        return response()->json([
            'message' => 'تم إزالة المتطلب السابق بنجاح',
            'data' => $course->load('prerequisites')
        ]);
    }
}