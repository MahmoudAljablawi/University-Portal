<?php

namespace App\Http\Controllers;

use App\Models\AcademicSemester;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AcademicSemesterController extends Controller implements HasMiddleware
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
        $semesters = AcademicSemester::all();
        return response()->json($semesters);
        //return view('semesters.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('semesters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:academic_semesters,code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $semester = AcademicSemester::create($validated);

        return response()->json([
            'message' => 'Academic Semester Created Successfully',
            'data' => $semester
        ], 201);
       // return redirect()->route('semesters.index')->with('success', 'Academic semester created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicSemester $academicSemester)
    {
        return response()->json($academicSemester->load('sections.course'));
        //return view('semesters.show', compact('semester'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicSemester $semester)
    {
        //return view('semesters.edit', compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicSemester $academicSemester)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:academic_semesters,code,' . $academicSemester->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $academicSemester->update($validated);

        return response()->json([
            'message' => 'Data Of Academic Semester Updated Successfully',
            'data' => $academicSemester
        ]);
        //return redirect()->route('semesters.index')->with('success', 'Academic semester updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicSemester $academicSemester)
    {
        $academicSemester->delete();

        return response()->json([
            'message' => 'Academic Semester Deleted Successfully'
        ]);
        //return redirect()->route('semesters.index')->with('success', 'Academic semester deleted successfully.');
    }
}
