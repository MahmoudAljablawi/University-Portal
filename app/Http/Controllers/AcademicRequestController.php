<?php

namespace App\Http\Controllers;

use App\Models\AcademicRequest;
use App\Models\User;
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

        $query = AcademicRequest::query()
            ->with('student');

        if ($user->role === 'student') {
            $query->where('student_id', $user->id);
        }


        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search, $user) {

                // Admin can search by student information.
                if ($user->role === 'admin') {
                    $query->whereHas('student', function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }

                // Both admin and student can search request data.
                $query->orWhere('request_type', 'like', "%{$search}%")
                    ->orWhere('reason', 'like', "%{$search}%");
            });
        }

        $query->when(
            $request->filled('request_type'),
            fn($query) => $query->where(
                'request_type',
                $request->input('request_type')
            )
        );

        $query->when(
            $request->filled('status'),
            fn($query) => $query->where(
                'status',
                $request->input('status')
            )
        );


        $requests = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $requestTypes = AcademicRequest::query()
            ->select('request_type')
            ->whereNotNull('request_type')
            ->distinct()
            ->orderBy('request_type')
            ->pluck('request_type');

        $statuses = AcademicRequest::query()
            ->select('status')
            ->whereNotNull('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        return $request->expectsJson()
            ? response()->json($requests)
            : view('academic-requests.index', compact(
                'requests',
                'requestTypes',
                'statuses'
            ));
    }


    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('academic-requests.create', compact('students'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->role !== 'student') {
            abort_unless($request->expectsJson(), 403);
            return response()->json(['message' => 'Only students can submit academic requests.'], 403);
        }

        $validated = $request->validate([
            'request_type' => 'required|string|max:100',
            'reason' => 'required|string',
        ]);

        $academicRequest = AcademicRequest::create([
            'student_id' => $user->id,
            'request_type' => $validated['request_type'],
            'reason' => $validated['reason'],
            'status' => 'pending', // الحالة الافتراضية قيد الانتظار
        ]);

        if (! $request->expectsJson()) {
            return redirect()->route('academic-requests.index')->with('success', 'Academic request created successfully.');
        }
        return response()->json([
            'message' => 'Academic Request Submitted Successfully',
            'data' => $academicRequest->load('student')
        ], 201);
        //return redirect()->route('academic-requests.index')->with('success', 'Academic request created successfully.');
    }

    public function show(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();
        $academicRequest->load('student');
        if ($user->role === 'student' && $user->id !== $academicRequest->student_id) {
            abort_unless($request->expectsJson(), 403);
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $request->expectsJson() ? response()->json($academicRequest->load('student')) : view('academic-requests.show', compact('academicRequest'));
    }
    public function edit(AcademicRequest $academicRequest)
    {
        $students = User::where('role', 'student')->get();
        return view('academic-requests.edit', compact('academicRequest', 'students'));
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

            if (! $request->expectsJson()) {
                return redirect()->route('academic-requests.index')->with('success', 'Academic request updated successfully.');
            }
            return response()->json([
                'message' => 'Academic Request Status Updated Successfully',
                'data' => $academicRequest->load('student')
            ]);
        }

        if ($user->role === 'student' && $user->id === $academicRequest->student_id) {
            if ($academicRequest->status !== 'pending') {
                if (! $request->expectsJson()) {
                    return back()->withErrors(['status' => 'Cannot modify a processed request.']);
                }
                return response()->json(['message' => 'Cannot modify a processed request.'], 422);
            }

            $validated = $request->validate([
                'request_type' => 'sometimes|string|max:100',
                'reason' => 'sometimes|string',
            ]);

            $academicRequest->update($validated);

            if (! $request->expectsJson()) {
                return redirect()->route('academic-requests.index')->with('success', 'Academic request updated successfully.');
            }
            return response()->json([
                'message' => 'Academic Request Updated Successfully',
                'data' => $academicRequest
            ]);
        }

        abort_unless($request->expectsJson(), 403);
        return response()->json(['message' => 'Unauthorized'], 403);
        // return redirect()->route('academic-requests.index')->with('success', 'Academic request updated successfully.');
    }

    public function destroy(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();

        if ($user->role === 'admin' || ($user->id === $academicRequest->student_id && $academicRequest->status === 'pending')) {
            $academicRequest->delete();

            if (! $request->expectsJson()) {
                return redirect()->route('academic-requests.index')->with('success', 'Academic request deleted successfully.');
            }
            return response()->json([
                'message' => 'Academic Request Deleted Successfully'
            ]);
        }

        abort_unless($request->expectsJson(), 403);
        return response()->json(['message' => 'Unauthorized'], 403);
        //return redirect()->route('academic-requests.index')->with('success', 'Academic request deleted successfully.');
    }
}
