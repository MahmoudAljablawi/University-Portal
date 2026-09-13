<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'section.course', 'grade'])->get();
        return response()->json($enrollments);
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
            'student_id' => 'required|exists:users,id',
            'section_id' => 'required|exists:course_sections,id',
            'status' => 'sometimes|in:enrolled,dropped,completed',
        ]);

        $enrollment = Enrollment::create($validated);

        return response()->json([
            'message' => 'Student successfully registered in the department',
            'data' => $enrollment->load(['student', 'section.course'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment->load(['student', 'section.course', 'grade']));
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
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'section_id' => 'required|exists:course_sections,id',
            'status' => 'required|in:enrolled,dropped,completed',
        ]);

        $enrollment->update($validated);

        return response()->json([
            'message' => 'Registration status updated successfully',
            'data' => $enrollment->load(['student', 'section.course'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json([
            'message' => 'Registration successfully canceled'
        ]);
    }
}