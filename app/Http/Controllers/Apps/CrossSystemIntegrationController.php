<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrossSystemIntegrationRequest;
use App\Models\CrossSystemIntegration;
use App\Models\User;
use App\Support\AuditTrailLogger;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CrossSystemIntegrationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:cross-system-integrations-access'),
            new Middleware('permission:cross-system-integrations-data', only: ['index']),
            new Middleware('permission:cross-system-integrations-create', only: ['create', 'store']),
            new Middleware('permission:cross-system-integrations-update', only: ['edit', 'update']),
            new Middleware('permission:cross-system-integrations-delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $crossSystemIntegrations = CrossSystemIntegration::query()
            ->leftJoin('users', 'users.id', '=', 'cross_system_integrations.owner_id')
            ->select('cross_system_integrations.*', 'users.name as owner_name')
            ->latest('cross_system_integrations.id')
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Maintenance/CrossSystemIntegrations/Index', [
            'crossSystemIntegrations' => $crossSystemIntegrations,
        ]);
    }

    public function create()
    {
        return inertia('Apps/Maintenance/CrossSystemIntegrations/Create', [
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(CrossSystemIntegrationRequest $request)
    {
        $crossSystemIntegration = CrossSystemIntegration::query()->create($request->validated());

        AuditTrailLogger::log('create', 'cross_system_integration', $crossSystemIntegration, 'Create cross-system integration', [
            'integration_no' => $crossSystemIntegration->integration_no,
        ]);

        return to_route('apps.cross-system-integrations.index');
    }

    public function edit(CrossSystemIntegration $crossSystemIntegration)
    {
        return inertia('Apps/Maintenance/CrossSystemIntegrations/Edit', [
            'crossSystemIntegration' => $crossSystemIntegration,
            'users' => User::query()->select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(CrossSystemIntegrationRequest $request, CrossSystemIntegration $crossSystemIntegration)
    {
        $crossSystemIntegration->update($request->validated());

        AuditTrailLogger::log('update', 'cross_system_integration', $crossSystemIntegration, 'Update cross-system integration', [
            'integration_no' => $crossSystemIntegration->integration_no,
        ]);

        return to_route('apps.cross-system-integrations.index');
    }

    public function destroy(CrossSystemIntegration $crossSystemIntegration)
    {
        AuditTrailLogger::log('delete', 'cross_system_integration', $crossSystemIntegration, 'Delete cross-system integration', [
            'integration_no' => $crossSystemIntegration->integration_no,
        ]);

        $crossSystemIntegration->delete();

        return back();
    }
}
