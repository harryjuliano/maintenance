<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\InspectionChecklistRequest;
use App\Models\Asset;
use App\Models\InspectionTemplate;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class InspectionChecklistController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:inspection-checklists-access'),
            new Middleware('permission:inspection-checklists-data', only: ['index']),
            new Middleware('permission:inspection-checklists-create', only: ['create', 'store']),
            new Middleware('permission:inspection-checklists-update', only: ['edit', 'update']),
            new Middleware('permission:inspection-checklists-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $inspectionChecklists = InspectionTemplate::query()
            ->leftJoin('assets', 'assets.id', '=', 'inspection_templates.asset_id')
            ->select('inspection_templates.*', 'assets.asset_name')
            ->latest('inspection_templates.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/InspectionChecklists/Index', [
            'inspectionChecklists' => $inspectionChecklists,
        ]);
    }

    public function create()
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();

        return inertia('Apps/Maintenance/InspectionChecklists/Create', [
            'assets' => $assets,
        ]);
    }

    public function store(InspectionChecklistRequest $request)
    {
        $inspectionChecklist = InspectionTemplate::query()->create([
            ...$request->validated(),
            'active' => (bool) $request->boolean('active', true),
        ]);

        AuditTrailLogger::log('create', 'inspection_checklist', $inspectionChecklist, 'Create inspection checklist', [
            'code' => $inspectionChecklist->code,
            'name' => $inspectionChecklist->name,
        ]);

        return to_route('apps.inspection-checklists.index');
    }

    public function edit(InspectionTemplate $inspectionChecklist)
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();

        return inertia('Apps/Maintenance/InspectionChecklists/Edit', [
            'inspectionChecklist' => $inspectionChecklist,
            'assets' => $assets,
        ]);
    }

    public function update(InspectionChecklistRequest $request, InspectionTemplate $inspectionChecklist)
    {
        $inspectionChecklist->update([
            ...$request->validated(),
            'active' => (bool) $request->boolean('active', false),
        ]);

        AuditTrailLogger::log('update', 'inspection_checklist', $inspectionChecklist, 'Update inspection checklist', [
            'code' => $inspectionChecklist->code,
            'name' => $inspectionChecklist->name,
        ]);

        return to_route('apps.inspection-checklists.index');
    }

    public function destroy(InspectionTemplate $inspectionChecklist)
    {
        AuditTrailLogger::log('delete', 'inspection_checklist', $inspectionChecklist, 'Delete inspection checklist', [
            'code' => $inspectionChecklist->code,
        ]);

        $inspectionChecklist->delete();

        return back();
    }
}
