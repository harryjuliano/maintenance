<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkRequestRequest;
use App\Models\Asset;
use App\Models\WorkRequest;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class WorkRequestController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:work-requests-access'),
            new Middleware('permission:work-requests-data', only: ['index']),
            new Middleware('permission:work-requests-create', only: ['create', 'store']),
            new Middleware('permission:work-requests-update', only: ['edit', 'update']),
            new Middleware('permission:work-requests-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $workRequests = WorkRequest::query()
            ->leftJoin('assets', 'assets.id', '=', 'work_requests.asset_id')
            ->select('work_requests.*', 'assets.asset_name')
            ->latest('work_requests.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/WorkRequests/Index', [
            'workRequests' => $workRequests,
        ]);
    }

    public function create()
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();

        return inertia('Apps/Maintenance/WorkRequests/Create', [
            'assets' => $assets,
        ]);
    }

    public function store(WorkRequestRequest $request)
    {
        $workRequest = WorkRequest::query()->create($request->validated());

        AuditTrailLogger::log('create', 'work_request', $workRequest, 'Create work request', ['request_no' => $workRequest->request_no]);

        return to_route('apps.work-requests.index');
    }

    public function edit(WorkRequest $workRequest)
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();

        return inertia('Apps/Maintenance/WorkRequests/Edit', [
            'workRequest' => $workRequest,
            'assets' => $assets,
        ]);
    }

    public function update(WorkRequestRequest $request, WorkRequest $workRequest)
    {
        $workRequest->update($request->validated());

        AuditTrailLogger::log('update', 'work_request', $workRequest, 'Update work request', ['request_no' => $workRequest->request_no]);

        return to_route('apps.work-requests.index');
    }

    public function destroy(WorkRequest $workRequest)
    {
        AuditTrailLogger::log('delete', 'work_request', $workRequest, 'Delete work request', ['request_no' => $workRequest->request_no]);

        $workRequest->delete();

        return back();
    }
}
