<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\AuditTrail;
use App\Support\AuditTrailLogger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuditTrailController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:audit-trails-access'),
            new Middleware('permission:audit-trails-data', only: ['index']),
            new Middleware('permission:audit-trails-delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $auditTrails = AuditTrail::query()
            ->leftJoin('users', 'users.id', '=', 'audit_trails.user_id')
            ->when($request->search, fn ($q) => $q
                ->where('audit_trails.module', 'like', "%{$request->search}%")
                ->orWhere('audit_trails.action', 'like', "%{$request->search}%")
                ->orWhere('users.name', 'like', "%{$request->search}%"))
            ->select('audit_trails.*', 'users.name as user_name')
            ->latest('audit_trails.id')
            ->paginate(15)
            ->withQueryString();

        return inertia('Apps/AuditTrails/Index', [
            'auditTrails' => $auditTrails,
        ]);
    }

    public function destroy(AuditTrail $auditTrail)
    {
        AuditTrailLogger::log('delete', 'audit_trail', $auditTrail, 'Delete audit trail entry', [
            'target_id' => $auditTrail->id,
            'target_action' => $auditTrail->action,
        ]);

        $auditTrail->delete();

        return back();
    }
}
