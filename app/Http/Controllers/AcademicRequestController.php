<?php

namespace App\Http\Controllers;

use App\Models\AcademicRequest;
use Illuminate\Http\Request;

class AcademicRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = AcademicRequest::with('student')->get();
        return response()->json($requests);
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
            'student_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'sometimes|in:pending,approved,rejected',
        ]);

        $academicRequest = AcademicRequest::create($validated);

        return response()->json([
            'message' => 'The academic application has been successfully submitted',
            'data' => $academicRequest->load('student')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicRequest $academicRequest)
    {
        return response()->json($academicRequest->load('student'));
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
    public function update(Request $request, AcademicRequest $academicRequest)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $academicRequest->update($validated);

        return response()->json([
            'message' => 'The academic application has been successfully updated',
            'data' => $academicRequest->load('student')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicRequest $academicRequest)
    {
        $academicRequest->delete();

        return response()->json([
            'message' => 'The academic application has been successfully deleted'
        ]);
    }
}