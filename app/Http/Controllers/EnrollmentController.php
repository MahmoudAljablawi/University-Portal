<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EnrollmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return response()->json(Enrollment::with(['student', 'section.course'])->get());
        } elseif ($user->role === 'instructor') {
            // الأستاذ يرى تسجيلات الشعب الخاصة به فقط
            return response()->json(Enrollment::whereHas('section', function ($query) use ($user) {
                $query->where('instructor_id', $user->id);
            })->with(['student', 'section.course'])->get());
        } else {
            // الطالب يرى تسجيلاته الشخصية فقط
            return response()->json(Enrollment::where('student_id', $user->id)->with(['section.course'])->get());
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'course_section_id' => 'required|exists:course_sections,id',
            'student_id' => $user->role === 'admin' ? 'required|exists:users,id' : 'prohibited',
        ]);

        $studentId = $user->role === 'admin' ? $validated['student_id'] : $user->id;

        // التحقق من عدم التكرار في نفس الشعبة
        $exists = Enrollment::where('student_id', $studentId)
            ->where('course_section_id', $validated['course_section_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Student is already enrolled in this section.'
            ], 422);
        }

        $enrollment = Enrollment::create([
            'student_id' => $studentId,
            'course_section_id' => $validated['course_section_id'],
            'status' => 'enrolled',
            'enrollment_date' => now(),
        ]);

        return response()->json([
            'message' => 'Enrollment Created Successfully',
            'data' => $enrollment->load(['section.course', 'student'])
        ], 201);
    }

    public function show(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $user->id !== $enrollment->student_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($enrollment->load(['student', 'section.course']));
    }

    public function destroy(Request $request, Enrollment $enrollment)
    {
        $user = $request->user();

        if ($user->role !== 'admin' && $user->id !== $enrollment->student_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $enrollment->delete();

        return response()->json([
            'message' => 'Enrollment Dropped Successfully'
        ]);
    }
}
