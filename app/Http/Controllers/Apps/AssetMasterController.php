<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetRequest;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;

class AssetMasterController extends Controller
{
    public function index()
    {
        $assets = Asset::query()
            ->select('id', 'asset_code', 'asset_name', 'asset_number', 'criticality_level', 'maintenance_strategy', 'status')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/Assets/Index', [
            'assets' => $assets,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/Assets/Create');
    }

    public function store(AssetRequest $request)
    {
        [$plantId, $areaId, $categoryId] = $this->ensureAssetMasterDependencies();

        Asset::create([
            ...$request->validated(),
            'plant_id' => $plantId,
            'area_id' => $areaId,
            'asset_category_id' => $categoryId,
        ]);

        return to_route('apps.assets.index');
    }

    public function edit(Asset $asset)
    {
        return inertia('Apps/Maintenance/Assets/Edit', [
            'asset' => $asset,
        ]);
    }

    public function update(AssetRequest $request, Asset $asset)
    {
        $asset->update($request->validated());

        return to_route('apps.assets.index');
    }

    public function destroy(Asset $asset)
    {
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
