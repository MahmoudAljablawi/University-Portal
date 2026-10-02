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
        $query = AuditLog::query()
            ->with('user');


        $search = trim((string) $request->input('search'));

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('action', 'like', "%{$search}%")
                    ->orWhere('target_table', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }


        $query->when(
            $request->filled('action'),
            fn($query) => $query->where(
                'action',
                $request->input('action')
            )
        );

        $query->when(
            $request->filled('target_table'),
            fn($query) => $query->where(
                'target_table',
                $request->input('target_table')
            )
        );

        $auditLogs = $query
            ->latest('id')
            ->paginate(15)
            ->withQueryString();


        $actions = AuditLog::query()
            ->select('action')
            ->whereNotNull('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $targetTables = AuditLog::query()
            ->select('target_table')
            ->whereNotNull('target_table')
            ->distinct()
            ->orderBy('target_table')
            ->pluck('target_table');


        return $request->expectsJson()
            ? response()->json($auditLogs)
            : view('audit-logs.index', compact(
                'auditLogs',
                'actions',
                'targetTables'
            ));
    }


    public function show(AuditLog $auditLog)
    {

        $auditLog->load('user');
        return request()->expectsJson() ? response()->json($auditLog->load('user')) : view('audit-logs.show', compact('auditLog'));
    }

    public function destroy(AuditLog $auditLog)
    {
        $auditLog->delete();

        return response()->json([
            'message' => 'Audit Log Deleted Successfully'
        ]);
    }
}
