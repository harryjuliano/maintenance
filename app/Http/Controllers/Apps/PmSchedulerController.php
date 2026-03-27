<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\PmSchedulerRequest;
use App\Models\Asset;
use App\Models\PreventiveMaintenanceSchedule;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class PmSchedulerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:pm-schedulers-access'),
            new Middleware('permission:pm-schedulers-data', only: ['index']),
            new Middleware('permission:pm-schedulers-create', only: ['create', 'store']),
            new Middleware('permission:pm-schedulers-update', only: ['edit', 'update']),
            new Middleware('permission:pm-schedulers-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $pmSchedulers = PreventiveMaintenanceSchedule::query()
            ->leftJoin('assets', 'assets.id', '=', 'preventive_maintenance_schedules.asset_id')
            ->leftJoin('preventive_maintenance_templates', 'preventive_maintenance_templates.id', '=', 'preventive_maintenance_schedules.template_id')
            ->select('preventive_maintenance_schedules.*', 'assets.asset_name', 'preventive_maintenance_templates.template_name')
            ->latest('preventive_maintenance_schedules.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/PmSchedulers/Index', [
            'pmSchedulers' => $pmSchedulers,
        ]);
    }

    public function create()
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();
        $templates = DB::table('preventive_maintenance_templates')->select('id', 'template_name')->orderBy('template_name')->get();

        return inertia('Apps/Maintenance/PmSchedulers/Create', [
            'assets' => $assets,
            'templates' => $templates,
        ]);
    }

    public function store(PmSchedulerRequest $request)
    {
        $pmScheduler = PreventiveMaintenanceSchedule::query()->create($request->validated());

        AuditTrailLogger::log('create', 'pm_scheduler', $pmScheduler, 'Create PM scheduler', [
            'template_id' => $pmScheduler->template_id,
            'asset_id' => $pmScheduler->asset_id,
        ]);

        return to_route('apps.pm-schedulers.index');
    }

    public function edit(PreventiveMaintenanceSchedule $pmScheduler)
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();
        $templates = DB::table('preventive_maintenance_templates')->select('id', 'template_name')->orderBy('template_name')->get();

        return inertia('Apps/Maintenance/PmSchedulers/Edit', [
            'pmScheduler' => $pmScheduler,
            'assets' => $assets,
            'templates' => $templates,
        ]);
    }

    public function update(PmSchedulerRequest $request, PreventiveMaintenanceSchedule $pmScheduler)
    {
        $pmScheduler->update($request->validated());

        AuditTrailLogger::log('update', 'pm_scheduler', $pmScheduler, 'Update PM scheduler', [
            'template_id' => $pmScheduler->template_id,
            'asset_id' => $pmScheduler->asset_id,
        ]);

        return to_route('apps.pm-schedulers.index');
    }

    public function destroy(PreventiveMaintenanceSchedule $pmScheduler)
    {
        AuditTrailLogger::log('delete', 'pm_scheduler', $pmScheduler, 'Delete PM scheduler', [
            'template_id' => $pmScheduler->template_id,
            'asset_id' => $pmScheduler->asset_id,
        ]);

        $pmScheduler->delete();

        return back();
    }
}
