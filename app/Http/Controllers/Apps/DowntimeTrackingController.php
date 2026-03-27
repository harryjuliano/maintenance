<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\DowntimeLogRequest;
use App\Models\Asset;
use App\Models\DowntimeLog;
use App\Models\WorkOrder;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DowntimeTrackingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:downtime-trackings-access'),
            new Middleware('permission:downtime-trackings-data', only: ['index']),
            new Middleware('permission:downtime-trackings-create', only: ['create', 'store']),
            new Middleware('permission:downtime-trackings-update', only: ['edit', 'update']),
            new Middleware('permission:downtime-trackings-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $downtimeTrackings = DowntimeLog::query()
            ->leftJoin('work_orders', 'work_orders.id', '=', 'downtime_logs.work_order_id')
            ->leftJoin('assets', 'assets.id', '=', 'downtime_logs.asset_id')
            ->select('downtime_logs.*', 'work_orders.work_order_no', 'assets.asset_name')
            ->latest('downtime_logs.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/DowntimeTrackings/Index', [
            'downtimeTrackings' => $downtimeTrackings,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/DowntimeTrackings/Create', [
            'assets' => Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get(),
            'workOrders' => WorkOrder::query()->select('id', 'work_order_no')->orderByDesc('id')->get(),
        ]);
    }

    public function store(DowntimeLogRequest $request)
    {
        $downtimeTracking = DowntimeLog::query()->create($request->validated());

        AuditTrailLogger::log('create', 'downtime_tracking', $downtimeTracking, 'Create downtime log', [
            'downtime_type' => $downtimeTracking->downtime_type,
            'total_minutes' => $downtimeTracking->total_minutes,
        ]);

        return to_route('apps.downtime-trackings.index');
    }

    public function edit(DowntimeLog $downtimeTracking)
    {
        return inertia('Apps/Maintenance/DowntimeTrackings/Edit', [
            'downtimeTracking' => $downtimeTracking,
            'assets' => Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get(),
            'workOrders' => WorkOrder::query()->select('id', 'work_order_no')->orderByDesc('id')->get(),
        ]);
    }

    public function update(DowntimeLogRequest $request, DowntimeLog $downtimeTracking)
    {
        $downtimeTracking->update($request->validated());

        AuditTrailLogger::log('update', 'downtime_tracking', $downtimeTracking, 'Update downtime log', [
            'downtime_type' => $downtimeTracking->downtime_type,
            'total_minutes' => $downtimeTracking->total_minutes,
        ]);

        return to_route('apps.downtime-trackings.index');
    }

    public function destroy(DowntimeLog $downtimeTracking)
    {
        AuditTrailLogger::log('delete', 'downtime_tracking', $downtimeTracking, 'Delete downtime log', [
            'downtime_type' => $downtimeTracking->downtime_type,
            'total_minutes' => $downtimeTracking->total_minutes,
        ]);

        $downtimeTracking->delete();

        return back();
    }
}
