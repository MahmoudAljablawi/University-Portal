<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuditLogController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
            new Middleware('role:admin'),
        ];
    }

    public function index(Request $request)
    {
        return response()->json(AuditLog::with('user')->latest()->get());
    }

    public function show(AuditLog $auditLog)
    {
        return response()->json($auditLog->load('user'));
    }

    public function destroy(AuditLog $auditLog)
    {
        $auditLog->delete();

        return response()->json([
            'message' => 'Audit Log Deleted Successfully'
        ]);
    }
}
