<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\SparePartRequest;
use App\Models\SparePart;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class SparePartControlController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:spare-parts-access'),
            new Middleware('permission:spare-parts-data', only: ['index']),
            new Middleware('permission:spare-parts-create', only: ['create', 'store']),
            new Middleware('permission:spare-parts-update', only: ['edit', 'update']),
            new Middleware('permission:spare-parts-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $spareParts = SparePart::query()
            ->leftJoin('spare_part_categories', 'spare_part_categories.id', '=', 'spare_parts.spare_part_category_id')
            ->select('spare_parts.*', DB::raw('spare_part_categories.name as category_name'))
            ->latest('spare_parts.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/SparePartControls/Index', [
            'spareParts' => $spareParts,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/SparePartControls/Create', [
            'categories' => DB::table('spare_part_categories')->select('id', 'name')->orderBy('name')->get(),
            'suppliers' => DB::table('suppliers')->select('id', 'supplier_name')->orderBy('supplier_name')->get(),
        ]);
    }

    public function store(SparePartRequest $request)
    {
        $sparePart = SparePart::query()->create($request->validated());

        AuditTrailLogger::log('create', 'spare_part', $sparePart, 'Create spare part', [
            'part_code' => $sparePart->part_code,
            'part_name' => $sparePart->part_name,
        ]);

        return to_route('apps.spare-parts.index');
    }

    public function edit(SparePart $sparePart)
    {
        return inertia('Apps/Maintenance/SparePartControls/Edit', [
            'sparePart' => $sparePart,
            'categories' => DB::table('spare_part_categories')->select('id', 'name')->orderBy('name')->get(),
            'suppliers' => DB::table('suppliers')->select('id', 'supplier_name')->orderBy('supplier_name')->get(),
        ]);
    }

    public function update(SparePartRequest $request, SparePart $sparePart)
    {
        $sparePart->update($request->validated());

        AuditTrailLogger::log('update', 'spare_part', $sparePart, 'Update spare part', [
            'part_code' => $sparePart->part_code,
            'part_name' => $sparePart->part_name,
        ]);

        return to_route('apps.spare-parts.index');
    }

    public function destroy(SparePart $sparePart)
    {
        AuditTrailLogger::log('delete', 'spare_part', $sparePart, 'Delete spare part', [
            'part_code' => $sparePart->part_code,
            'part_name' => $sparePart->part_name,
        ]);

        $sparePart->delete();

        return back();
    }
}
