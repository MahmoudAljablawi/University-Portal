<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colleges = College::with('departments')->get();
        return response()->json($colleges);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     */
    public function show(College $college)
    {
        return response()->json($college->load('departments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            'message' => 'Data Of Collage Updated Successfully',
            'data' => $college
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(College $college)
    {
        $college->delete();

        return response()->json([
            'message' => 'Collage Deleted Successfully'
        ]);
    }
}
