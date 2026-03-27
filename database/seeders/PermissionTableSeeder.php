<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'dashboard-access',
            'dashboard-data',

            'assets-access',
            'assets-data',
            'assets-create',
            'assets-update',
            'assets-delete',

            'work-requests-access',
            'work-requests-data',
            'work-requests-create',
            'work-requests-update',
            'work-requests-delete',

            'work-orders-access',
            'work-orders-data',
            'work-orders-create',
            'work-orders-update',
            'work-orders-delete',

            'breakdowns-access',
            'breakdowns-data',
            'breakdowns-create',
            'breakdowns-update',
            'breakdowns-delete',

            'pm-schedulers-access',
            'pm-schedulers-data',
            'pm-schedulers-create',
            'pm-schedulers-update',
            'pm-schedulers-delete',

            'inspection-checklists-access',
            'inspection-checklists-data',
            'inspection-checklists-create',
            'inspection-checklists-update',
            'inspection-checklists-delete',

            'calibration-supports-access',
            'calibration-supports-data',
            'calibration-supports-create',
            'calibration-supports-update',
            'calibration-supports-delete',

            'downtime-trackings-access',
            'downtime-trackings-data',
            'downtime-trackings-create',
            'downtime-trackings-update',
            'downtime-trackings-delete',

            'spare-parts-access',
            'spare-parts-data',
            'spare-parts-create',
            'spare-parts-update',
            'spare-parts-delete',

            'notifications-access',
            'notifications-data',
            'notifications-create',
            'notifications-update',
            'notifications-delete',

            'operational-reports-access',
            'operational-reports-data',
            'operational-reports-create',
            'operational-reports-update',
            'operational-reports-delete',

            'users-access',
            'users-data',
            'users-create',
            'users-update',
            'users-delete',

            'roles-access',
            'roles-data',
            'roles-create',
            'roles-update',
            'roles-delete',

            'permissions-access',
            'permissions-data',
            'permissions-create',
            'permissions-update',
            'permissions-delete',

            'audit-trails-access',
            'audit-trails-data',
            'audit-trails-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }
    }
}
