<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkOrderRequest;
use App\Models\Asset;
use App\Models\WorkOrder;
use App\Models\WorkRequest;

class WorkOrderController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::query()
            ->leftJoin('assets', 'assets.id', '=', 'work_orders.asset_id')
            ->leftJoin('work_requests', 'work_requests.id', '=', 'work_orders.work_request_id')
            ->select('work_orders.*', 'assets.asset_name', 'work_requests.request_no')
            ->latest('work_orders.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/WorkOrders/Index', [
            'workOrders' => $workOrders,
        ]);
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

        WorkOrder::create([
            ...$request->validated(),
            'area_id' => $asset->area_id,
            'production_line_id' => $asset->production_line_id,
        ]);

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

        return to_route('apps.work-orders.index');
    }

    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();

        return back();
    }
}
