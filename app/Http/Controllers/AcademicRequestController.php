<?php

namespace App\Http\Controllers;

use App\Models\AcademicRequest;
use App\Support\DataScope;
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
        abort_unless(
            in_array($user->role, ['admin', 'employee', 'student']),
            403
        );

        $scope = DataScope::academicRequests($user);
        $query = (clone $scope)
            ->with('student');

        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search, $user) {

                // Admin can search by student information.
                if (in_array($user->role, ['admin', 'employee'])) {
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

        $requestTypes = (clone $scope)
            ->select('request_type')
            ->whereNotNull('request_type')
            ->distinct()
            ->orderBy('request_type')
            ->pluck('request_type');

        $statuses = (clone $scope)
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


    public function create(Request $request)
    {
        abort_unless(
            $request->user()->role === 'student',
            403
        );

        return view('academic-requests.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        abort_unless(
            $user->role === 'student',
            403
        );

        $validated = $request->validate([
            'request_type' => [
                'required',
                'in:grade_inquiry,enrollment_pause,objection',
            ],
            'reason' => [
                'required',
                'string',
            ],
        ]);

        $academicRequest = AcademicRequest::create([
            'student_id' => $user->id,
            'request_type' => $validated['request_type'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        if (! $request->expectsJson()) {
            return redirect()
                ->route('academic-requests.index')
                ->with('success', __('Academic request created successfully.'));
        }

        return response()->json([
            'message' => __('Academic Request Submitted Successfully'),
            'data' => $academicRequest->load('student'),
        ], 201);
    }

    public function show(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['admin', 'employee', 'student']),
            403
        );
        DataScope::ensureVisible($user, $academicRequest);

        $academicRequest->load('student');

        return $request->expectsJson()
            ? response()->json($academicRequest)
            : view('academic-requests.show', compact('academicRequest'));
    }

    public function edit(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();
        DataScope::ensureVisible($user, $academicRequest);

        abort_unless(
            $user->role === 'student' &&
                $user->id === $academicRequest->student_id,
            403
        );

        abort_unless(
            $academicRequest->status === 'pending',
            422,
            'Cannot modify a processed request.'
        );

        return view('academic-requests.edit', compact('academicRequest'));
    }

    public function update(
        Request $request,
        AcademicRequest $academicRequest
    ) {
        $user = $request->user();
        DataScope::ensureVisible($user, $academicRequest);

        abort_unless(
            $user->role === 'student' &&
                $user->id === $academicRequest->student_id,
            403
        );

        abort_unless(
            $academicRequest->status === 'pending',
            422,
            'Cannot modify a processed request.'
        );

        $validated = $request->validate([
            'request_type' => [
                'required',
                'in:grade_inquiry,enrollment_pause,objection',
            ],
            'reason' => [
                'required',
                'string',
            ],
        ]);

        $academicRequest->update($validated);

        if (! $request->expectsJson()) {
            return redirect()
                ->route('academic-requests.index')
                ->with('success', __('Academic request updated successfully.'));
        }

        return response()->json([
            'message' => __('Academic Request Updated Successfully'),
            'data' => $academicRequest->load('student'),
        ]);
    }

    public function destroy(
        Request $request,
        AcademicRequest $academicRequest
    ) {
        $user = $request->user();
        DataScope::ensureVisible($user, $academicRequest);

        abort_unless(
            $user->role === 'student' &&
                $user->id === $academicRequest->student_id,
            403
        );

        abort_unless(
            $academicRequest->status === 'pending',
            422,
            'Cannot delete a processed request.'
        );

        $academicRequest->delete();

        if (! $request->expectsJson()) {
            return redirect()
                ->route('academic-requests.index')
                ->with('success', __('Academic request deleted successfully.'));
        }

        return response()->json([
            'message' => __('Academic Request Deleted Successfully'),
        ]);
    }

    public function approve(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['employee', 'admin']),
            403
        );
        DataScope::ensureVisible($user, $academicRequest);

        abort_unless(
            $academicRequest->status === 'pending',
            422,
            'Only pending requests can be approved.'
        );

        $academicRequest->update([
            'status' => 'approved',
        ]);

        if (! $request->expectsJson()) {
            return redirect()
                ->route('academic-requests.index')
                ->with('success', __('Academic request approved successfully.'));
        }

        return response()->json([
            'message' => __('Academic Request Approved Successfully'),
            'data' => $academicRequest->load('student'),
        ]);
    }

    public function reject(Request $request, AcademicRequest $academicRequest)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['employee', 'admin']),
            403
        );
        DataScope::ensureVisible($user, $academicRequest);

        abort_unless(
            $academicRequest->status === 'pending',
            422,
            'Only pending requests can be rejected.'
        );

        $academicRequest->update([
            'status' => 'rejected',
        ]);

        if (! $request->expectsJson()) {
            return redirect()
                ->route('academic-requests.index')
                ->with('success', __('Academic request rejected successfully.'));
        }

        return response()->json([
            'message' => __('Academic Request Rejected Successfully'),
            'data' => $academicRequest->load('student'),
        ]);
    }
}
