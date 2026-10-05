<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\College;
use App\Support\DataScope;
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

    public function index(Request $request)
    {
        $user = $request->user();
        $query = DataScope::departments($user)->with('college');

        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $query->when(
            $request->filled('college_id'),
            fn($query) => $query->where('college_id', $request->input('college_id'))
        );


        $departments = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();


        $colleges = DataScope::colleges($user)->orderBy('name')->get(['id', 'name']);

        return $request->expectsJson()
            ? response()->json($departments)
            : view('departments.index', compact('departments', 'colleges'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colleges = College::all();
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
            return redirect()->route('departments.index')->with('success', __('Department created successfully.'));
        }
        return response()->json([
            'message' => __('Department Created Successfully'),
            'data' => $department->load('college')
        ], 201);
        //return redirect()->route('departments.index')->with('success', __('Department created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        $user = request()->user();
        DataScope::ensureVisible($user, $department);
        $department->load([
            'college',
            'courses' => fn ($courses) => $courses->whereIn(
                'courses.id',
                DataScope::courses($user)->select('courses.id')
            ),
        ]);

        return request()->expectsJson()
            ? response()->json($department)
            : view('departments.show', compact('department'));
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
            return redirect()->route('departments.index')->with('success', __('Department updated successfully.'));
        }
        return response()->json([
            'message' => __('Data Of Department Updated Successfully'),
            'data' => $department->load('college')
        ]);
        //return redirect()->route('departments.index')->with('success', __('Department updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        if (! request()->expectsJson()) {
            return redirect()->route('departments.index')->with('success', __('Department deleted successfully.'));
        }
        return response()->json([
            'message' => __('Department Deleted Successfully')
        ]);
        //return redirect()->route('departments.index')->with('success', __('Department deleted successfully.'));
    }
}
