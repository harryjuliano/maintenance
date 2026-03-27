<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvancedReportingAnalyticRequest;
use App\Models\AdvancedReportingAnalytic;
use App\Models\User;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdvancedReportingAnalyticController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:advanced-reporting-analytics-access'),
            new Middleware('permission:advanced-reporting-analytics-data', only: ['index']),
            new Middleware('permission:advanced-reporting-analytics-create', only: ['create', 'store']),
            new Middleware('permission:advanced-reporting-analytics-update', only: ['edit', 'update']),
            new Middleware('permission:advanced-reporting-analytics-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $advancedReportingAnalytics = AdvancedReportingAnalytic::query()
            ->leftJoin('users', 'users.id', '=', 'advanced_reporting_analytics.prepared_by')
            ->select('advanced_reporting_analytics.*', 'users.name as prepared_by_name')
            ->latest('advanced_reporting_analytics.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/AdvancedReportingAnalytics/Index', [
            'advancedReportingAnalytics' => $advancedReportingAnalytics,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/AdvancedReportingAnalytics/Create', [
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(AdvancedReportingAnalyticRequest $request)
    {
        $advancedReportingAnalytic = AdvancedReportingAnalytic::query()->create($request->validated());

        AuditTrailLogger::log('create', 'advanced_reporting_analytic', $advancedReportingAnalytic, 'Create advanced reporting analytic', [
            'analytics_no' => $advancedReportingAnalytic->analytics_no,
        ]);

        return to_route('apps.advanced-reporting-analytics.index');
    }

    public function edit(AdvancedReportingAnalytic $advancedReportingAnalytic)
    {
        return inertia('Apps/Maintenance/AdvancedReportingAnalytics/Edit', [
            'advancedReportingAnalytic' => $advancedReportingAnalytic,
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(AdvancedReportingAnalyticRequest $request, AdvancedReportingAnalytic $advancedReportingAnalytic)
    {
        $advancedReportingAnalytic->update($request->validated());

        AuditTrailLogger::log('update', 'advanced_reporting_analytic', $advancedReportingAnalytic, 'Update advanced reporting analytic', [
            'analytics_no' => $advancedReportingAnalytic->analytics_no,
        ]);

        return to_route('apps.advanced-reporting-analytics.index');
    }

    public function destroy(AdvancedReportingAnalytic $advancedReportingAnalytic)
    {
        AuditTrailLogger::log('delete', 'advanced_reporting_analytic', $advancedReportingAnalytic, 'Delete advanced reporting analytic', [
            'analytics_no' => $advancedReportingAnalytic->analytics_no,
        ]);

        $advancedReportingAnalytic->delete();

        return back();
    }
}
