<?php

namespace App\Http\Controllers;

use App\Models\AcademicRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AcademicRequestController extends Controller implements HasMiddleware
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
            return response()->json(AcademicRequest::with('student')->get());
        } else {
            return response()->json(AcademicRequest::where('student_id', $user->id)->get());
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'student') {
            return response()->json(['message' => 'Only students can submit academic requests.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100', // مثل: postponement, add_drop, etc.
            'description' => 'required|string',
        ]);

        $academicRequest = AcademicRequest::create([
            'student_id' => $user->id,
            'title' => $validated['title'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'status' => 'pending', // الحالة الافتراضية قيد الانتظار
        ]);

        return response()->json([
            'message' => 'Academic Request Submitted Successfully',
            'data' => $academicRequest->load('student')
        ], 201);
    }

    public function show(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();

        if ($user->role === 'student' && $user->id !== $academicRequest->student_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($academicRequest->load('student'));
    }

    public function update(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();

        // الـ Admin فقط هو من يمكنه تغيير حالة الطلب (قبول/رفض)
        if ($user->role === 'admin') {
            $validated = $request->validate([
                'status' => 'required|in:pending,approved,rejected',
                'admin_notes' => 'nullable|string|max:255',
            ]);

            $academicRequest->update($validated);

            return response()->json([
                'message' => 'Academic Request Status Updated Successfully',
                'data' => $academicRequest->load('student')
            ]);
        }

        if ($user->role === 'student' && $user->id === $academicRequest->student_id) {
            if ($academicRequest->status !== 'pending') {
                return response()->json(['message' => 'Cannot modify a processed request.'], 422);
            }

            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'type' => 'sometimes|string|max:100',
                'description' => 'sometimes|string',
            ]);

            $academicRequest->update($validated);

            return response()->json([
                'message' => 'Academic Request Updated Successfully',
                'data' => $academicRequest
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    public function destroy(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();

        if ($user->role === 'admin' || ($user->id === $academicRequest->student_id && $academicRequest->status === 'pending')) {
            $academicRequest->delete();

            return response()->json([
                'message' => 'Academic Request Deleted Successfully'
            ]);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}