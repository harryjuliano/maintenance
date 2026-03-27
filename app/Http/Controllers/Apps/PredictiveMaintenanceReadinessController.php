<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\PredictiveMaintenanceReadinessRequest;
use App\Models\Asset;
use App\Models\PredictiveMaintenanceReadiness;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PredictiveMaintenanceReadinessController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:predictive-maintenance-readinesses-access'),
            new Middleware('permission:predictive-maintenance-readinesses-data', only: ['index']),
            new Middleware('permission:predictive-maintenance-readinesses-create', only: ['create', 'store']),
            new Middleware('permission:predictive-maintenance-readinesses-update', only: ['edit', 'update']),
            new Middleware('permission:predictive-maintenance-readinesses-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $predictiveMaintenanceReadinesses = PredictiveMaintenanceReadiness::query()
            ->leftJoin('assets', 'assets.id', '=', 'predictive_maintenance_readinesses.asset_id')
            ->select('predictive_maintenance_readinesses.*', 'assets.asset_name')
            ->latest('predictive_maintenance_readinesses.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/PredictiveMaintenanceReadinesses/Index', [
            'predictiveMaintenanceReadinesses' => $predictiveMaintenanceReadinesses,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/PredictiveMaintenanceReadinesses/Create', [
            'assets' => Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get(),
        ]);
    }

    public function store(PredictiveMaintenanceReadinessRequest $request)
    {
        $predictiveMaintenanceReadiness = PredictiveMaintenanceReadiness::query()->create($request->validated());

        AuditTrailLogger::log('create', 'predictive_maintenance_readiness', $predictiveMaintenanceReadiness, 'Create predictive maintenance readiness', [
            'readiness_no' => $predictiveMaintenanceReadiness->readiness_no,
        ]);

        return to_route('apps.predictive-maintenance-readinesses.index');
    }

    public function edit(PredictiveMaintenanceReadiness $predictiveMaintenanceReadiness)
    {
        return inertia('Apps/Maintenance/PredictiveMaintenanceReadinesses/Edit', [
            'predictiveMaintenanceReadiness' => $predictiveMaintenanceReadiness,
            'assets' => Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get(),
        ]);
    }

    public function update(PredictiveMaintenanceReadinessRequest $request, PredictiveMaintenanceReadiness $predictiveMaintenanceReadiness)
    {
        $predictiveMaintenanceReadiness->update($request->validated());

        AuditTrailLogger::log('update', 'predictive_maintenance_readiness', $predictiveMaintenanceReadiness, 'Update predictive maintenance readiness', [
            'readiness_no' => $predictiveMaintenanceReadiness->readiness_no,
        ]);

        return to_route('apps.predictive-maintenance-readinesses.index');
    }

    public function destroy(PredictiveMaintenanceReadiness $predictiveMaintenanceReadiness)
    {
        AuditTrailLogger::log('delete', 'predictive_maintenance_readiness', $predictiveMaintenanceReadiness, 'Delete predictive maintenance readiness', [
            'readiness_no' => $predictiveMaintenanceReadiness->readiness_no,
        ]);

        $predictiveMaintenanceReadiness->delete();

        return back();
    }
}
