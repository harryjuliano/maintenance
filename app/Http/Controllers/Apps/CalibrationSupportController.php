<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalibrationSupportRequest;
use App\Models\Asset;
use App\Models\CalibrationSupport;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CalibrationSupportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:calibration-supports-access'),
            new Middleware('permission:calibration-supports-data', only: ['index']),
            new Middleware('permission:calibration-supports-create', only: ['create', 'store']),
            new Middleware('permission:calibration-supports-update', only: ['edit', 'update']),
            new Middleware('permission:calibration-supports-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $calibrationSupports = CalibrationSupport::query()
            ->leftJoin('assets', 'assets.id', '=', 'calibration_supports.asset_id')
            ->select('calibration_supports.*', 'assets.asset_name')
            ->latest('calibration_supports.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/CalibrationSupports/Index', [
            'calibrationSupports' => $calibrationSupports,
        ]);
    }

    public function create()
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();

        return inertia('Apps/Maintenance/CalibrationSupports/Create', [
            'assets' => $assets,
        ]);
    }

    public function store(CalibrationSupportRequest $request)
    {
        $calibrationSupport = CalibrationSupport::query()->create($request->validated());

        AuditTrailLogger::log('create', 'calibration_support', $calibrationSupport, 'Create calibration support', [
            'calibration_no' => $calibrationSupport->calibration_no,
            'status' => $calibrationSupport->status,
        ]);

        return to_route('apps.calibration-supports.index');
    }

    public function edit(CalibrationSupport $calibrationSupport)
    {
        $assets = Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get();

        return inertia('Apps/Maintenance/CalibrationSupports/Edit', [
            'calibrationSupport' => $calibrationSupport,
            'assets' => $assets,
        ]);
    }

    public function update(CalibrationSupportRequest $request, CalibrationSupport $calibrationSupport)
    {
        $calibrationSupport->update($request->validated());

        AuditTrailLogger::log('update', 'calibration_support', $calibrationSupport, 'Update calibration support', [
            'calibration_no' => $calibrationSupport->calibration_no,
            'status' => $calibrationSupport->status,
        ]);

        return to_route('apps.calibration-supports.index');
    }

    public function destroy(CalibrationSupport $calibrationSupport)
    {
        AuditTrailLogger::log('delete', 'calibration_support', $calibrationSupport, 'Delete calibration support', [
            'calibration_no' => $calibrationSupport->calibration_no,
        ]);

        $calibrationSupport->delete();

        return back();
    }
}
