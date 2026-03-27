<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkOrderRequest;
use App\Models\Asset;
use App\Models\WorkOrder;
use App\Models\WorkRequest;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class WorkOrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:work-orders-access'),
            new Middleware('permission:work-orders-data', only: ['index']),
            new Middleware('permission:work-orders-create', only: ['create', 'store']),
            new Middleware('permission:work-orders-update', only: ['edit', 'update']),
            new Middleware('permission:work-orders-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $workOrders = WorkOrder::query()
            ->leftJoin('assets', 'assets.id', '=', 'work_orders.asset_id')
            ->leftJoin('work_requests', 'work_requests.id', '=', 'work_orders.work_request_id')
            ->select('work_orders.*', 'assets.asset_name', 'work_requests.request_no')
            ->latest('work_orders.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/WorkOrders/Index', ['workOrders' => $workOrders]);
    }

    public function create()
    {
        $assets = Asset::query()->select('id', 'asset_name', 'area_id', 'production_line_id')->orderBy('asset_name')->get();
        $workRequests = WorkRequest::query()->select('id', 'request_no')->latest()->get();

        return inertia('Apps/Maintenance/WorkOrders/Create', [
            'assets' => $assets,
            'workRequests' => $workRequests,
        ]);
    }

    public function store(WorkOrderRequest $request)
    {
        $asset = Asset::query()->findOrFail($request->asset_id);

        $workOrder = WorkOrder::query()->create([
            ...$request->validated(),
            'area_id' => $asset->area_id,
            'production_line_id' => $asset->production_line_id,
        ]);

        AuditTrailLogger::log('create', 'work_order', $workOrder, 'Create work order', ['work_order_no' => $workOrder->work_order_no]);

        return to_route('apps.work-orders.index');
    }

    public function edit(WorkOrder $workOrder)
    {
        $assets = Asset::query()->select('id', 'asset_name', 'area_id', 'production_line_id')->orderBy('asset_name')->get();
        $workRequests = WorkRequest::query()->select('id', 'request_no')->latest()->get();

        return inertia('Apps/Maintenance/WorkOrders/Edit', [
            'workOrder' => $workOrder,
            'assets' => $assets,
            'workRequests' => $workRequests,
        ]);
    }

    public function update(WorkOrderRequest $request, WorkOrder $workOrder)
    {
        $asset = Asset::query()->findOrFail($request->asset_id);

        $workOrder->update([
            ...$request->validated(),
            'area_id' => $asset->area_id,
            'production_line_id' => $asset->production_line_id,
        ]);

        AuditTrailLogger::log('update', 'work_order', $workOrder, 'Update work order', ['work_order_no' => $workOrder->work_order_no]);

        return to_route('apps.work-orders.index');
    }

    public function destroy(WorkOrder $workOrder)
    {
        AuditTrailLogger::log('delete', 'work_order', $workOrder, 'Delete work order', ['work_order_no' => $workOrder->work_order_no]);

        $workOrder->delete();

        return back();
    }
}
