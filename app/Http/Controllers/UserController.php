<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:admin'), // مخصص للـ admin بالكامل
        ];
    }
    public function index(Request $request)
    {
        $query = User::query();

        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $query->when(
            $request->filled('role'),
            fn($query) => $query
                ->where(
                    'role',
                    $request->input('role')
                )
        );
        $query->when(
            $request->filled('status'),
            function ($query) use ($request) {
                $query->where(
                    'is_active',
                    $request->input('status') === 'active'
                );
            }
        );

        $users = $query->latest('id')->paginate(15)->withQueryString();

        return request()->expectsJson() ? response()->json($users) : view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colleges = College::orderBy('name')->get();

        return view('users.create', compact('colleges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:50',
            'role' => 'required|in:admin,instructor,student,employee',
            'is_active' => 'boolean',
            'college_id' => [
                'nullable',
                'exists:colleges,id',
                Rule::requiredIf(fn() => $request->input('role') === 'employee'),
            ],
        ]);
        if ($validated['role'] !== 'employee') {
            $validated['college_id'] = null;
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('users.index')->with('success', __('User created successfully.'));
        }
        return response()->json([
            'message' => __('User Created Successfully'),
            'data' => $user
        ], 201);
        //return redirect()->route('users.index')->with('success', __('User created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return request()->expectsJson() ? response()->json($user->load(['teachingSections', 'enrollments', 'academicRequests'])) : view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $colleges = College::orderBy('name')->get();

        return view('users.edit', compact('user', 'colleges'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'role' => 'required|in:admin,instructor,student,employee',
            'is_active' => 'boolean',
            'college_id' => [
                'nullable',
                'exists:colleges,id',
                Rule::requiredIf(fn() => $request->input('role') === 'employee'),
            ],
        ]);

        if ($validated['role'] !== 'employee') {
            $validated['college_id'] = null;
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('users.index')->with('success', __('User updated successfully.'));
        }
        return response()->json([
            'message' => __('Data Of User Updated Successfully'),
            'data' => $user
        ]);
        //return redirect()->route('users.index')->with('success', __('User updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        if (! request()->expectsJson()) {
            return redirect()->route('users.index')->with('success', __('User deleted successfully.'));
        }
        return response()->json([
            'message' => __('User Deleted Successfully')
        ]);
        //return redirect()->route('users.index')->with('success', __('User deleted successfully.'));
    }
}
