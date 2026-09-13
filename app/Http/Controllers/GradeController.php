<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with(['enrollment.student', 'enrollment.section.course'])->get();
        return response()->json($grades);
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
            'enrollment_id' => 'required|exists:enrollments,id|unique:grades,enrollment_id',
            'midterm_grade' => 'nullable|numeric|min:0|max:100',
            'final_grade' => 'nullable|numeric|min:0|max:100',
            'total_grade' => 'nullable|numeric|min:0|max:100',
            'letter_grade' => 'nullable|string|max:5',
            'is_published' => 'boolean',
        ]);

        $grade = Grade::create($validated);

        return response()->json([
            'message' => 'Grade Added Successfully',
            'data' => $grade->load(['enrollment.student', 'enrollment.section.course'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return response()->json($grade->load(['enrollment.student', 'enrollment.section.course']));
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
    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id|unique:grades,enrollment_id,' . $grade->id,
            'midterm_grade' => 'nullable|numeric|min:0|max:100',
            'final_grade' => 'nullable|numeric|min:0|max:100',
            'total_grade' => 'nullable|numeric|min:0|max:100',
            'letter_grade' => 'nullable|string|max:5',
            'is_published' => 'boolean',
        ]);

        $grade->update($validated);

        return response()->json([
            'message' => 'Grade Successfully Updated',
            'data' => $grade->load(['enrollment.student', 'enrollment.section.course'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();

        return response()->json([
            'message' => 'Grade Successfully Deleted'
        ]);
    }
}