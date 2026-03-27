<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\RcaCapaRequest;
use App\Models\RcaCapa;
use App\Models\User;
use App\Models\WorkOrder;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RcaCapaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:rca-capas-access'),
            new Middleware('permission:rca-capas-data', only: ['index']),
            new Middleware('permission:rca-capas-create', only: ['create', 'store']),
            new Middleware('permission:rca-capas-update', only: ['edit', 'update']),
            new Middleware('permission:rca-capas-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $rcaCapas = RcaCapa::query()
            ->leftJoin('work_orders', 'work_orders.id', '=', 'rca_capas.work_order_id')
            ->leftJoin('users', 'users.id', '=', 'rca_capas.owner_id')
            ->select('rca_capas.*', 'work_orders.wo_no', 'users.name as owner_name')
            ->latest('rca_capas.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/RcaCapas/Index', [
            'rcaCapas' => $rcaCapas,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/RcaCapas/Create', [
            'workOrders' => WorkOrder::query()->select('id', 'wo_no')->orderByDesc('id')->get(),
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(RcaCapaRequest $request)
    {
        $rcaCapa = RcaCapa::query()->create($request->validated());

        AuditTrailLogger::log('create', 'rca_capa', $rcaCapa, 'Create RCA CAPA', ['rca_no' => $rcaCapa->rca_no, 'status' => $rcaCapa->status]);

        return to_route('apps.rca-capas.index');
    }

    public function edit(RcaCapa $rcaCapa)
    {
        return inertia('Apps/Maintenance/RcaCapas/Edit', [
            'rcaCapa' => $rcaCapa,
            'workOrders' => WorkOrder::query()->select('id', 'wo_no')->orderByDesc('id')->get(),
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(RcaCapaRequest $request, RcaCapa $rcaCapa)
    {
        $rcaCapa->update($request->validated());

        AuditTrailLogger::log('update', 'rca_capa', $rcaCapa, 'Update RCA CAPA', ['rca_no' => $rcaCapa->rca_no, 'status' => $rcaCapa->status]);

        return to_route('apps.rca-capas.index');
    }

    public function destroy(RcaCapa $rcaCapa)
    {
        AuditTrailLogger::log('delete', 'rca_capa', $rcaCapa, 'Delete RCA CAPA', ['rca_no' => $rcaCapa->rca_no]);

        $rcaCapa->delete();

        return back();
    }
}
