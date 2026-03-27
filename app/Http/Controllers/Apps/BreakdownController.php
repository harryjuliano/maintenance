<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkRequestRequest;
use App\Models\Asset;
use App\Models\WorkRequest;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BreakdownController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:breakdowns-access'),
            new Middleware('permission:breakdowns-data', only: ['index']),
            new Middleware('permission:breakdowns-create', only: ['create', 'store']),
            new Middleware('permission:breakdowns-update', only: ['edit', 'update']),
            new Middleware('permission:breakdowns-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $breakdowns = WorkRequest::query()
            ->leftJoin('assets', 'assets.id', '=', 'work_requests.asset_id')
            ->select('work_requests.*', 'assets.asset_name')
            ->where('work_requests.request_type', 'breakdown')
            ->latest('work_requests.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/Breakdowns/Index', [
            'breakdowns' => $breakdowns,
        ]);
    }

    public function create()
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();

        return inertia('Apps/Maintenance/Breakdowns/Create', [
            'assets' => $assets,
        ]);
    }

    public function store(WorkRequestRequest $request)
    {
        $breakdown = WorkRequest::query()->create([
            ...$request->validated(),
            'request_type' => 'breakdown',
        ]);

        AuditTrailLogger::log('create', 'breakdown', $breakdown, 'Create breakdown request', [
            'request_no' => $breakdown->request_no,
            'status' => $breakdown->status,
        ]);

        return to_route('apps.breakdowns.index');
    }

    public function edit(WorkRequest $breakdown)
    {
        abort_unless($breakdown->request_type === 'breakdown', 404);

        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();

        return inertia('Apps/Maintenance/Breakdowns/Edit', [
            'breakdown' => $breakdown,
            'assets' => $assets,
        ]);
    }

    public function update(WorkRequestRequest $request, WorkRequest $breakdown)
    {
        abort_unless($breakdown->request_type === 'breakdown', 404);

        $breakdown->update([
            ...$request->validated(),
            'request_type' => 'breakdown',
        ]);

        AuditTrailLogger::log('update', 'breakdown', $breakdown, 'Update breakdown request', [
            'request_no' => $breakdown->request_no,
            'status' => $breakdown->status,
        ]);

        return to_route('apps.breakdowns.index');
    }

    public function destroy(WorkRequest $breakdown)
    {
        abort_unless($breakdown->request_type === 'breakdown', 404);

        AuditTrailLogger::log('delete', 'breakdown', $breakdown, 'Delete breakdown request', [
            'request_no' => $breakdown->request_no,
        ]);

        $breakdown->delete();

        return back();
    }
}
