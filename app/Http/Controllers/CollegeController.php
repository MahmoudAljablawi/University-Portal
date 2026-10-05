<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Support\DataScope;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CollegeController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            // يتطلب تسجيل الدخول لجميع العمليات
            new Middleware('auth:sanctum'),

            // عمليات التعديل والإنشاء والحذف مخصصة للـ admin فقط
            new Middleware('role:admin', except: ['index', 'show']),
        ];
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $query = DataScope::colleges($user)->with([
            'departments' => fn ($departments) => $departments->whereIn(
                'departments.id',
                DataScope::departments($user)->select('departments.id')
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


        $colleges = $query
            ->latest('id')
            ->paginate(10)
            ->withQueryString();


        return $request->expectsJson()
            ? response()->json($colleges)
            : view('colleges.index', compact('colleges'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colleges.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colleges,name',
            'code' => 'required|string|max:50|unique:colleges,code',
        ]);

        $college = College::create($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('colleges.index')->with('success', __('College created successfully.'));
        }
        return response()->json([
            'message' => __('College Created Successfully'),
            'data' => $college
        ], 201);
        //return redirect()->route('colleges.index')->with('success', __('College created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(College $college)
    {
        $user = request()->user();
        DataScope::ensureVisible($user, $college);
        $college->load([
            'departments' => fn ($departments) => $departments->whereIn(
                'departments.id',
                DataScope::departments($user)->select('departments.id')
            ),
        ]);

        return request()->expectsJson()
            ? response()->json($college)
            : view('colleges.show', compact('college'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(College $college)
    {
        return view('colleges.edit', compact('college'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, College $college)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colleges,name,' . $college->id,
            'code' => 'required|string|max:50|unique:colleges,code,' . $college->id,
        ]);

        $college->update($validated);

        if (! $request->expectsJson()) {
            return redirect()->route('colleges.index')->with('success', __('College updated successfully.'));
        }
        return response()->json([
            'message' => __('Data Of College Updated Successfully'),
            'data' => $college
        ]);
        //return redirect()->route('colleges.index')->with('success', __('College updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(College $college)
    {
        $college->delete();

        if (! request()->expectsJson()) {
            return redirect()->route('colleges.index')->with('success', __('College deleted successfully.'));
        }
        return response()->json([
            'message' => __('College Deleted Successfully')
        ]);
        //return redirect()->route('colleges.index')->with('success', __('College deleted successfully.'));
    }
}
