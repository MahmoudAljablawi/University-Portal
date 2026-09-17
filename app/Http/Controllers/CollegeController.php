<?php

namespace App\Http\Controllers;

use App\Models\College;
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
    public function index()
    {
        $colleges = College::with('departments')->get();
        return response()->json($colleges);
        //return view('colleges.index', compact('colleges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('colleges.create');
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

        return response()->json([
            'message' => 'College Created Successfully',
            'data' => $college
        ], 201);
        //return redirect()->route('colleges.index')->with('success', 'College created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(College $college)
    {
        return response()->json($college->load('departments'));
        //return view('colleges.show', compact('college'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //return view('colleges.edit', compact('college'));
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

        return response()->json([
            'message' => 'Data Of College Updated Successfully',
            'data' => $college
        ]);
        //return redirect()->route('colleges.index')->with('success', 'College updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(College $college)
    {
        $college->delete();

        return response()->json([
            'message' => 'College Deleted Successfully'
        ]);
        //return redirect()->route('colleges.index')->with('success', 'College deleted successfully.');
    }
}
