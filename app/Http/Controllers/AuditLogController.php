<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = AuditLog::with('user')->latest()->get();
        return response()->json($logs);
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
            'user_id' => 'nullable|exists:users,id',
            'action' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ip_address' => 'nullable|ip',
        ]);

        $auditLog = AuditLog::create($validated);

        return response()->json([
            'message' => 'The event has been successfully registered',
            'data' => $auditLog->load('user')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditLog $auditLog)
    {
        return response()->json($auditLog->load('user'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditLog $auditLog)
    {
        $auditLog->delete();

        return response()->json([
            'message' => 'The event has been successfully deleted'
        ]);
    }
}
