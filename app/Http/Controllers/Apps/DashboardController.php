<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AuditTrail;
use App\Models\WorkOrder;
use App\Models\WorkRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:dashboard-access'),
            new Middleware('permission:dashboard-data'),
        ];
    }

    public function __invoke(Request $request)
    {
        $summary = [
            'active_assets' => Asset::query()->where('status', 'active')->count(),
            'open_work_orders' => WorkOrder::query()->whereNotIn('status', ['completed', 'verified', 'closed', 'cancelled'])->count(),
            'submitted_work_requests' => WorkRequest::query()->whereIn('status', ['submitted', 'reviewed', 'approved'])->count(),
            'breakdown_open' => WorkRequest::query()->where('request_type', 'breakdown')->whereNotIn('status', ['closed', 'converted'])->count(),
        ];

        $statusChart = WorkOrder::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        $breakdownTrend = WorkRequest::query()
            ->selectRaw("DATE_FORMAT(request_date, '%Y-%m') as month, count(*) as total")
            ->where('request_type', 'breakdown')
            ->where('request_date', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $recentAudits = AuditTrail::query()
            ->leftJoin('users', 'users.id', '=', 'audit_trails.user_id')
            ->select('audit_trails.id', 'audit_trails.action', 'audit_trails.module', 'audit_trails.description', 'audit_trails.created_at', 'users.name as user_name')
            ->latest('audit_trails.id')
            ->limit(6)
            ->get();

        return inertia('Apps/Dashboard', [
            'summary' => $summary,
            'statusChart' => $statusChart,
            'breakdownTrend' => $breakdownTrend,
            'recentAudits' => $recentAudits,
        ]);
    }
}
