<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DepartmentController extends Controller implements HasMiddleware
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
        $departments = Department::with('college')->get();
        return request()->expectsJson() ? response()->json($departments) : view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colleges = \App\Models\College::all();
        return view('departments.create', compact('colleges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code',
            'college_id' => 'required|exists:colleges,id',
        ]);

        $department = Department::create($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('departments.index')->with('success', 'Department created successfully.');
        }
        return response()->json([
            'message' => 'Department Created Successfully',
            'data' => $department->load('college')
        ], 201);
        //return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return request()->expectsJson() ? response()->json($department->load('college', 'courses')) : view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $colleges = \App\Models\College::all();
        return view('departments.edit', compact('department', 'colleges'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code,' . $department->id,
            'college_id' => 'required|exists:colleges,id',
        ]);

        $department->update($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
        }
        return response()->json([
            'message' => 'Data Of Department Updated Successfully',
            'data' => $department->load('college')
        ]);
        //return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        if (! request()->expectsJson()) {
            return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
        }
        return response()->json([
            'message' => 'Department Deleted Successfully'
        ]);
        //return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
