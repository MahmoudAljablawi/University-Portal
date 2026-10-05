<?php

namespace App\Http\Controllers;

use App\Models\AcademicSemester;
use App\Support\DataScope;
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
    public function index(Request $request)
    {
        $query = DataScope::semesters($request->user());

        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $query->when(
            $request->filled('status'),
            fn($query) => $query->where(
                'is_active',
                $request->input('status') === 'active'
            )
        );

        $semesters = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return $request->expectsJson()
            ? response()->json($semesters)
            : view('academic-semesters.index', compact('semesters'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academic-semesters.create');
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

        if (! $request->expectsJson()) {
            return redirect()->route('academic-semesters.index')->with('success', __('Academic semester created successfully.'));
        }
        return response()->json([
            'message' => __('Academic Semester Created Successfully'),
            'data' => $semester
        ], 201);
        // return redirect()->route('semesters.index')->with('success', __('Academic semester created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicSemester $academicSemester)
    {
        $user = request()->user();
        DataScope::ensureVisible($user, $academicSemester);
        $academicSemester->load([
            'courseSections' => fn ($sections) => $sections
                ->whereIn('course_sections.id', DataScope::courseSections($user)->select('course_sections.id'))
                ->with('course'),
        ]);

        return request()->expectsJson()
            ? response()->json($academicSemester)
            : view('academic-semesters.show', compact('academicSemester'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademicSemester $academicSemester)
    {
        return view('academic-semesters.edit', compact('academicSemester'));
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

        if (! $request->expectsJson()) {
            return redirect()->route('academic-semesters.index')->with('success', __('Academic semester updated successfully.'));
        }
        return response()->json([
            'message' => __('Data Of Academic Semester Updated Successfully'),
            'data' => $academicSemester
        ]);
        //return redirect()->route('semesters.index')->with('success', __('Academic semester updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicSemester $academicSemester)
    {
        $academicSemester->delete();

        if (! request()->expectsJson()) {
            return redirect()->route('academic-semesters.index')->with('success', __('Academic semester deleted successfully.'));
        }
        return response()->json([
            'message' => __('Academic Semester Deleted Successfully')
        ]);
        //return redirect()->route('semesters.index')->with('success', __('Academic semester deleted successfully.'));
    }
}
