<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationalReportRequest;
use App\Models\OperationalReport;
use App\Models\User;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OperationalReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:operational-reports-access'),
            new Middleware('permission:operational-reports-data', only: ['index']),
            new Middleware('permission:operational-reports-create', only: ['create', 'store']),
            new Middleware('permission:operational-reports-update', only: ['edit', 'update']),
            new Middleware('permission:operational-reports-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $operationalReports = OperationalReport::query()
            ->leftJoin('users', 'users.id', '=', 'operational_reports.prepared_by')
            ->select('operational_reports.*', 'users.name as prepared_by_name')
            ->latest('operational_reports.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/OperationalReports/Index', [
            'operationalReports' => $operationalReports,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/OperationalReports/Create', [
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(OperationalReportRequest $request)
    {
        $operationalReport = OperationalReport::query()->create($request->validated());

        AuditTrailLogger::log('create', 'operational_report', $operationalReport, 'Create operational report', [
            'report_no' => $operationalReport->report_no,
            'status' => $operationalReport->status,
        ]);

        return to_route('apps.operational-reports.index');
    }

    public function edit(OperationalReport $operationalReport)
    {
        return inertia('Apps/Maintenance/OperationalReports/Edit', [
            'operationalReport' => $operationalReport,
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(OperationalReportRequest $request, OperationalReport $operationalReport)
    {
        $operationalReport->update($request->validated());

        AuditTrailLogger::log('update', 'operational_report', $operationalReport, 'Update operational report', [
            'report_no' => $operationalReport->report_no,
            'status' => $operationalReport->status,
        ]);

        return to_route('apps.operational-reports.index');
    }

    public function destroy(OperationalReport $operationalReport)
    {
        AuditTrailLogger::log('delete', 'operational_report', $operationalReport, 'Delete operational report', [
            'report_no' => $operationalReport->report_no,
            'status' => $operationalReport->status,
        ]);

        $operationalReport->delete();

        return back();
    }
}
