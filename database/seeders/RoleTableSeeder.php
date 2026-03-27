<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            'users-access' => ['users-%'],
            'roles-access' => ['roles-%'],
            'permission-access' => ['permissions-%'],
            'maintenance-access' => ['dashboard-%', 'assets-%', 'work-requests-%', 'work-orders-%', 'breakdowns-%', 'pm-schedulers-%', 'inspection-checklists-%', 'calibration-supports-%', 'downtime-trackings-%', 'spare-parts-%', 'notifications-%', 'operational-reports-%', 'rca-capas-%', 'kpi-reliabilities-%', 'planner-calendars-%', 'mobile-technician-flows-%'],
            'audit-access' => ['audit-trails-%'],
        ];

        foreach ($groups as $roleName => $patterns) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            $permissions = Permission::query()
                ->where(function ($query) use ($patterns) {
                    foreach ($patterns as $pattern) {
                        $query->orWhere('name', 'like', $pattern);
                    }
                })
                ->get();

            $role->syncPermissions($permissions);
        }

        Role::firstOrCreate(['name' => 'super-admin']);
    }
}
