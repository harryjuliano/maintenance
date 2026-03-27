<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class AssetMasterController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:assets-access'),
            new Middleware('permission:assets-data', only: ['index']),
            new Middleware('permission:assets-create', only: ['create', 'store']),
            new Middleware('permission:assets-update', only: ['edit', 'update']),
            new Middleware('permission:assets-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $assets = Asset::query()
            ->select('id', 'asset_code', 'asset_name', 'asset_number', 'criticality_level', 'maintenance_strategy', 'status')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/Assets/Index', ['assets' => $assets]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/Assets/Create');
    }

    public function store(AssetRequest $request)
    {
        [$plantId, $areaId, $categoryId] = $this->ensureAssetMasterDependencies();

        $asset = Asset::query()->create([
            ...$request->validated(),
            'plant_id' => $plantId,
            'area_id' => $areaId,
            'asset_category_id' => $categoryId,
        ]);

        AuditTrailLogger::log('create', 'asset', $asset, 'Create asset', ['asset_code' => $asset->asset_code]);

        return to_route('apps.assets.index');
    }

    public function edit(Asset $asset)
    {
        return inertia('Apps/Maintenance/Assets/Edit', ['asset' => $asset]);
    }

    public function update(AssetRequest $request, Asset $asset)
    {
        $asset->update($request->validated());

        AuditTrailLogger::log('update', 'asset', $asset, 'Update asset', ['asset_code' => $asset->asset_code]);

        return to_route('apps.assets.index');
    }

    public function destroy(Asset $asset)
    {
        AuditTrailLogger::log('delete', 'asset', $asset, 'Delete asset', ['asset_code' => $asset->asset_code]);

        $asset->delete();

        return back();
    }

    private function ensureAssetMasterDependencies(): array
    {
        $plantId = DB::table('plants')->value('id');

        if (! $plantId) {
            $plantId = DB::table('plants')->insertGetId([
                'code' => 'PLANT-01',
                'name' => 'Plant 1',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $areaId = DB::table('areas')->where('plant_id', $plantId)->value('id');

        if (! $areaId) {
            $areaId = DB::table('areas')->insertGetId([
                'plant_id' => $plantId,
                'code' => 'AREA-01',
                'name' => 'General Area',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $categoryId = DB::table('asset_categories')->value('id');

        if (! $categoryId) {
            $categoryId = DB::table('asset_categories')->insertGetId([
                'code' => 'GENERAL',
                'name' => 'General Category',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return [$plantId, $areaId, $categoryId];
    }
}
