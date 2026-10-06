<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Support\DataScope;
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

    public function index(Request $request)
    {
        $user = $request->user();
        $query = DataScope::courses($user)->with([
            'department',
            'prerequisites' => fn ($courses) => $courses->whereIn(
                'courses.id',
                DataScope::courses($user)->select('courses.id')
            ),
        ]);


        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $query->when(
            $request->filled('department_id'),
            fn($query) => $query->where(
                'department_id',
                $request->input('department_id')
            )
        );

        $courses = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $departments = DataScope::departments($user)->orderBy('name')->get(['id', 'name']);

        return $request->expectsJson()
            ? response()->json($courses)
            : view('courses.index', compact('courses', 'departments'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('courses.create', compact('departments'));
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
            'semester_level' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $course = Course::create($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('courses.index')->with('success', __('Course created successfully.'));
        }
        return response()->json([
            'message' => __('Course Created Successfully'),
            'data' => $course->load('department')
        ], 201);
        //return redirect()->route('courses.index')->with('success', __('Course created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $user = request()->user();
        DataScope::ensureVisible($user, $course);
        $crs = $course->load([
            'department',
            'prerequisites' => fn ($courses) => $courses->whereIn(
                'courses.id',
                DataScope::courses($user)->select('courses.id')
            ),
            'sections' => fn ($sections) => $sections->whereIn(
                'course_sections.id',
                DataScope::courseSections($user)->select('course_sections.id')
            ),
        ]);
        $allCourses = DataScope::courses($user)
            ->where('courses.id', '!=', $course->id)
            ->get();
        return request()->expectsJson() ? response()->json($crs) : view('courses.show', compact('course', 'allCourses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $departments = Department::all();
        return view('courses.edit', compact('course', 'departments'));
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
            'semester_level' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $course->update($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('courses.index')->with('success', __('Course updated successfully.'));
        }
        return response()->json([
            'message' => __('Data Of Course Updated Successfully'),
            'data' => $course->load('department')
        ]);
        //return redirect()->route('courses.index')->with('success', __('Course updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        if (! request()->expectsJson()) {
            return redirect()->route('courses.index')->with('success', __('Course deleted successfully.'));
        }
        return response()->json([
            'message' => __('Course Deleted Successfully')
        ]);
        //return redirect()->route('courses.index')->with('success', __('Course deleted successfully.'));
    }
    public function addPrerequisite(Request $request, Course $course)
    {
        $validated = $request->validate([
            'prerequisite_id' => 'required|exists:courses,id|different:id',
        ]);

        // ربط المقرر بالمتطلب السابق عبر جدول الـ Pivot
        $course->prerequisites()->syncWithoutDetaching($validated['prerequisite_id']);

        if (! $request->expectsJson()) {
            return back()->with('success', __('Prerequisite added successfully.'));
        }
        return response()->json([
            'message' => __('Prerequisite added successfully.'),
            'data' => $course->load('prerequisites')
        ]);
        //return back()->with('success', 'Prerequisite added successfully.');
    }
    public function removePrerequisite(Request $request, Course $course)
    {
        $validated = $request->validate([
            'prerequisite_id' => 'required|exists:courses,id',
        ]);

        $course->prerequisites()->detach($validated['prerequisite_id']);

        if (! $request->expectsJson()) {
            return back()->with('success', __('Prerequisite removed successfully.'));
        }
        return response()->json([
            'message' => __('Prerequisite removed successfully.'),
            'data' => $course->load('prerequisites')
        ]);
        //return back()->with('success', 'Prerequisite removed successfully.');
    }
}
