<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Support\AuditTrailLogger;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:roles-access'),
            new Middleware('permission:roles-data', only: ['index']),
            new Middleware('permission:roles-create', only: ['store']),
            new Middleware('permission:roles-update', only: ['update']),
            new Middleware('permission:roles-delete', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        $roles = Role::query()
            ->with('permissions')
            ->when($request->search, fn ($query) => $query->where('name', 'like', '%'.$request->search.'%'))
            ->select('id', 'name')
            ->latest()
            ->paginate(7)
            ->withQueryString();

        $permissions = Permission::query()->select('id', 'name')->orderBy('name')->get();

        return inertia('Apps/Roles/Index', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function store(RoleRequest $request)
    {
        $role = Role::query()->create(['name' => $request->name]);
        $role->givePermissionTo($request->selectedPermission);

        AuditTrailLogger::log('create', 'role', $role, 'Create role', ['role_name' => $role->name]);

        return back();
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->selectedPermission);

        AuditTrailLogger::log('update', 'role', $role, 'Update role', ['role_name' => $role->name]);

        return back();
    }

    public function destroy(Role $role)
    {
        AuditTrailLogger::log('delete', 'role', $role, 'Delete role', ['role_name' => $role->name]);

        $role->delete();

        return back();
    }
}
