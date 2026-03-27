<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileTechnicianFlowRequest;
use App\Models\MobileTechnicianFlow;
use App\Models\User;
use App\Models\WorkOrder;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MobileTechnicianFlowController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:mobile-technician-flows-access'),
            new Middleware('permission:mobile-technician-flows-data', only: ['index']),
            new Middleware('permission:mobile-technician-flows-create', only: ['create', 'store']),
            new Middleware('permission:mobile-technician-flows-update', only: ['edit', 'update']),
            new Middleware('permission:mobile-technician-flows-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $mobileTechnicianFlows = MobileTechnicianFlow::query()
            ->leftJoin('work_orders', 'work_orders.id', '=', 'mobile_technician_flows.work_order_id')
            ->leftJoin('users', 'users.id', '=', 'mobile_technician_flows.technician_id')
            ->select('mobile_technician_flows.*', 'work_orders.wo_no', 'users.name as technician_name')
            ->latest('mobile_technician_flows.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/MobileTechnicianFlows/Index', [
            'mobileTechnicianFlows' => $mobileTechnicianFlows,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/MobileTechnicianFlows/Create', [
            'workOrders' => WorkOrder::query()->select('id', 'wo_no')->orderByDesc('id')->get(),
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(MobileTechnicianFlowRequest $request)
    {
        $mobileTechnicianFlow = MobileTechnicianFlow::query()->create($request->validated());

        AuditTrailLogger::log('create', 'mobile_technician_flow', $mobileTechnicianFlow, 'Create mobile technician flow', ['flow_no' => $mobileTechnicianFlow->flow_no]);

        return to_route('apps.mobile-technician-flows.index');
    }

    public function edit(MobileTechnicianFlow $mobileTechnicianFlow)
    {
        return inertia('Apps/Maintenance/MobileTechnicianFlows/Edit', [
            'mobileTechnicianFlow' => $mobileTechnicianFlow,
            'workOrders' => WorkOrder::query()->select('id', 'wo_no')->orderByDesc('id')->get(),
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(MobileTechnicianFlowRequest $request, MobileTechnicianFlow $mobileTechnicianFlow)
    {
        $mobileTechnicianFlow->update($request->validated());

        AuditTrailLogger::log('update', 'mobile_technician_flow', $mobileTechnicianFlow, 'Update mobile technician flow', ['flow_no' => $mobileTechnicianFlow->flow_no]);

        return to_route('apps.mobile-technician-flows.index');
    }

    public function destroy(MobileTechnicianFlow $mobileTechnicianFlow)
    {
        AuditTrailLogger::log('delete', 'mobile_technician_flow', $mobileTechnicianFlow, 'Delete mobile technician flow', ['flow_no' => $mobileTechnicianFlow->flow_no]);

        $mobileTechnicianFlow->delete();

        return back();
    }
}
