<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkRequestRequest;
use App\Models\Asset;
use App\Models\WorkRequest;

class WorkRequestController extends Controller
{
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
        WorkRequest::create($request->validated());

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

        return to_route('apps.work-requests.index');
    }

    public function destroy(WorkRequest $workRequest)
    {
        $workRequest->delete();

        return back();
    }
}
