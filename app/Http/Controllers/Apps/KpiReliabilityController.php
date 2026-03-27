<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\KpiReliabilityRequest;
use App\Models\Asset;
use App\Models\KpiReliability;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class KpiReliabilityController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:kpi-reliabilities-access'),
            new Middleware('permission:kpi-reliabilities-data', only: ['index']),
            new Middleware('permission:kpi-reliabilities-create', only: ['create', 'store']),
            new Middleware('permission:kpi-reliabilities-update', only: ['edit', 'update']),
            new Middleware('permission:kpi-reliabilities-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $kpiReliabilities = KpiReliability::query()
            ->leftJoin('assets', 'assets.id', '=', 'kpi_reliabilities.asset_id')
            ->select('kpi_reliabilities.*', 'assets.asset_name')
            ->latest('kpi_reliabilities.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/KpiReliabilities/Index', [
            'kpiReliabilities' => $kpiReliabilities,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/KpiReliabilities/Create', [
            'assets' => Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get(),
        ]);
    }

    public function store(KpiReliabilityRequest $request)
    {
        $kpiReliability = KpiReliability::query()->create($request->validated());

        AuditTrailLogger::log('create', 'kpi_reliability', $kpiReliability, 'Create KPI reliability', ['kpi_code' => $kpiReliability->kpi_code]);

        return to_route('apps.kpi-reliabilities.index');
    }

    public function edit(KpiReliability $kpiReliability)
    {
        return inertia('Apps/Maintenance/KpiReliabilities/Edit', [
            'kpiReliability' => $kpiReliability,
            'assets' => Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get(),
        ]);
    }

    public function update(KpiReliabilityRequest $request, KpiReliability $kpiReliability)
    {
        $kpiReliability->update($request->validated());

        AuditTrailLogger::log('update', 'kpi_reliability', $kpiReliability, 'Update KPI reliability', ['kpi_code' => $kpiReliability->kpi_code]);

        return to_route('apps.kpi-reliabilities.index');
    }

    public function destroy(KpiReliability $kpiReliability)
    {
        AuditTrailLogger::log('delete', 'kpi_reliability', $kpiReliability, 'Delete KPI reliability', ['kpi_code' => $kpiReliability->kpi_code]);

        $kpiReliability->delete();

        return back();
    }
}
