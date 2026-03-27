<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlannerCalendarRequest;
use App\Models\Asset;
use App\Models\PlannerCalendar;
use App\Models\User;
use App\Models\WorkOrder;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PlannerCalendarController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:planner-calendars-access'),
            new Middleware('permission:planner-calendars-data', only: ['index']),
            new Middleware('permission:planner-calendars-create', only: ['create', 'store']),
            new Middleware('permission:planner-calendars-update', only: ['edit', 'update']),
            new Middleware('permission:planner-calendars-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $plannerCalendars = PlannerCalendar::query()
            ->leftJoin('assets', 'assets.id', '=', 'planner_calendars.asset_id')
            ->leftJoin('work_orders', 'work_orders.id', '=', 'planner_calendars.work_order_id')
            ->leftJoin('users', 'users.id', '=', 'planner_calendars.assigned_to')
            ->select('planner_calendars.*', 'assets.asset_name', 'work_orders.wo_no', 'users.name as assigned_to_name')
            ->latest('planner_calendars.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/PlannerCalendars/Index', [
            'plannerCalendars' => $plannerCalendars,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/PlannerCalendars/Create', [
            'assets' => Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get(),
            'workOrders' => WorkOrder::query()->select('id', 'wo_no')->orderByDesc('id')->get(),
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(PlannerCalendarRequest $request)
    {
        $plannerCalendar = PlannerCalendar::query()->create($request->validated());

        AuditTrailLogger::log('create', 'planner_calendar', $plannerCalendar, 'Create planner calendar', ['plan_no' => $plannerCalendar->plan_no]);

        return to_route('apps.planner-calendars.index');
    }

    public function edit(PlannerCalendar $plannerCalendar)
    {
        return inertia('Apps/Maintenance/PlannerCalendars/Edit', [
            'plannerCalendar' => $plannerCalendar,
            'assets' => Asset::query()->select('id', 'asset_name')->orderBy('asset_name')->get(),
            'workOrders' => WorkOrder::query()->select('id', 'wo_no')->orderByDesc('id')->get(),
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(PlannerCalendarRequest $request, PlannerCalendar $plannerCalendar)
    {
        $plannerCalendar->update($request->validated());

        AuditTrailLogger::log('update', 'planner_calendar', $plannerCalendar, 'Update planner calendar', ['plan_no' => $plannerCalendar->plan_no]);

        return to_route('apps.planner-calendars.index');
    }

    public function destroy(PlannerCalendar $plannerCalendar)
    {
        AuditTrailLogger::log('delete', 'planner_calendar', $plannerCalendar, 'Delete planner calendar', ['plan_no' => $plannerCalendar->plan_no]);

        $plannerCalendar->delete();

        return back();
    }
}
