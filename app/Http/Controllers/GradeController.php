<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GradeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:admin,instructor', except: ['index', 'show']),
        ];
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return response()->json(Grade::with(['student', 'section.course'])->get());
        } elseif ($user->role === 'instructor') {
            return response()->json(Grade::whereHas('section', function ($q) use ($user) {
                $q->where('instructor_id', $user->id);
            })->with(['student', 'section.course'])->get());
        } else {
            return response()->json(Grade::where('student_id', $user->id)->with(['section.course'])->get());
        }
        //return view('grades.index');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_section_id' => 'required|exists:course_sections,id',
            'grade' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:255',
        ]);

        // إذا كان المستخدم أستاذ، نتأكد أنه يدرس هذه الشعبة فعلاً
        if ($user->role === 'instructor') {
            $isInstructorOfSection = CourseSection::where('id', $validated['course_section_id'])
                ->where('instructor_id', $user->id)
                ->exists();

            if (! $isInstructorOfSection) {
                return response()->json(['message' => 'عذراً، لست الأستاذ المسؤول عن هذه الشعبة.'], 403);
            }
        }

        $grade = Grade::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'course_section_id' => $validated['course_section_id'],
            ],
            [
                'grade' => $validated['grade'],
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return response()->json([
            'message' => 'Grade Saved Successfully',
            'data' => $grade->load(['student', 'section.course'])
        ], 201);

        //return redirect()->route('grades.index')->with('success', 'Grade recorded successfully.');
    }

    public function show(Request $request, Grade $grade)
    {
        $user = $request->user();
        $grade->load(['enrollment.student', 'enrollment.courseSection.course']);
        if ($user->role === 'student' && $user->id !== $grade->student_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($grade->load(['student', 'section.course']));
        //return view('grades.show', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $user = $request->user();

        if ($user->role === 'instructor') {
            $grade->load('section');
            if ($grade->section->instructor_id !== $user->id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $validated = $request->validate([
            'grade' => 'sometimes|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:255',
        ]);

        $grade->update($validated);

        return response()->json([
            'message' => 'Grade Updated Successfully',
            'data' => $grade->load(['student', 'section.course'])
        ]);
        //return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Request $request, Grade $grade)
    {
        $user = $request->user();

        if ($user->role === 'instructor') {
            $grade->load('section');
            if ($grade->section->instructor_id !== $user->id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $grade->delete();

        return response()->json([
            'message' => 'Grade Deleted Successfully'
        ]);
        //return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }
}
