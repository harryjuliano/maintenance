import { usePage } from '@inertiajs/react';
import {
    IconActivityHeartbeat,
    IconAdjustments,
    IconAlertTriangle,
    IconBuildingFactory2,
    IconCalendarDue,
    IconClipboardList,
    IconHistory,
    IconLayout2,
    IconPackages,
    IconReportAnalytics,
    IconRouteAltLeft,
    IconTool,
    IconBell,
    IconClockPause,
    IconUserBolt,
    IconUserShield,
    IconUsers,
} from '@tabler/icons-react';
import hasAnyPermission from './Permissions';
import React from 'react';

export default function Menu() {
    const { url } = usePage();

    const menuNavigation = [
        {
            title: 'Dashboard',
            permissions: hasAnyPermission(['dashboard-access']),
            details: [
                {
                    title: 'Maintenance Overview',
                    href: '/apps/dashboard',
                    active: url.startsWith('/apps/dashboard'),
                    icon: <IconLayout2 size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
                },
                {
                    title: 'Blueprint & Roadmap',
                    href: '/apps/maintenance-blueprint',
                    active: url.startsWith('/apps/maintenance-blueprint'),
                    icon: <IconRouteAltLeft size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
                },
            ],
        },
        {
            title: 'Operations',
            permissions: hasAnyPermission(['work-requests-access', 'work-orders-access', 'assets-access', 'breakdowns-access', 'pm-schedulers-access', 'inspection-checklists-access', 'calibration-supports-access', 'downtime-trackings-access', 'spare-parts-access', 'notifications-access', 'operational-reports-access']),
            details: [
                {
                    title: 'Breakdown Handling',
                    href: '/apps/breakdowns',
                    active: url.startsWith('/apps/breakdowns'),
                    icon: <IconAlertTriangle size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['breakdowns-access']),
                },
                {
                    title: 'Work Request',
                    href: '/apps/work-requests',
                    active: url.startsWith('/apps/work-requests'),
                    icon: <IconClipboardList size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['work-requests-access']),
                },
                {
                    title: 'Work Order',
                    href: '/apps/work-orders',
                    active: url.startsWith('/apps/work-orders'),
                    icon: <IconTool size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['work-orders-access']),
                },
                {
                    title: 'PM Scheduler',
                    href: '/apps/pm-schedulers',
                    active: url.startsWith('/apps/pm-schedulers'),
                    icon: <IconCalendarDue size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['pm-schedulers-access']),
                },
                {
                    title: 'Inspection Checklist',
                    href: '/apps/inspection-checklists',
                    active: url.startsWith('/apps/inspection-checklists'),
                    icon: <IconClipboardList size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['inspection-checklists-access']),
                },
                {
                    title: 'Calibration Support',
                    href: '/apps/calibration-supports',
                    active: url.startsWith('/apps/calibration-supports'),
                    icon: <IconTool size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['calibration-supports-access']),
                },
                {
                    title: 'Assets & Reliability',
                    href: '/apps/assets',
                    active: url.startsWith('/apps/assets'),
                    icon: <IconBuildingFactory2 size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['assets-access']),
                },
                {
                    title: 'Downtime Tracking',
                    href: '/apps/downtime-trackings',
                    active: url.startsWith('/apps/downtime-trackings'),
                    icon: <IconClockPause size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['downtime-trackings-access']),
                },
                {
                    title: 'Spare Part Control',
                    href: '/apps/spare-parts',
                    active: url.startsWith('/apps/spare-parts'),
                    icon: <IconPackages size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['spare-parts-access']),
                },
                {
                    title: 'Notification',
                    href: '/apps/notifications',
                    active: url.startsWith('/apps/notifications'),
                    icon: <IconBell size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['notifications-access']),
                },
                {
                    title: 'RCA & CAPA',
                    href: '/apps/dashboard',
                    active: false,
                    icon: <IconActivityHeartbeat size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
                },
                {
                    title: 'Reports & KPI',
                    href: '/apps/operational-reports',
                    active: url.startsWith('/apps/operational-reports'),
                    icon: <IconReportAnalytics size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['operational-reports-access']),
                },
            ],
        },
        {
            title: 'Administration',
            permissions: hasAnyPermission(['permissions-access']) || hasAnyPermission(['roles-access']) || hasAnyPermission(['users-access']) || hasAnyPermission(['audit-trails-access']),
            details: [
                {
                    title: 'Hak Akses',
                    href: '/apps/permissions',
                    active: url.startsWith('/apps/permissions'),
                    icon: <IconUserBolt size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['permissions-access']),
                },
                {
                    title: 'Akses Group',
                    href: '/apps/roles',
                    active: url.startsWith('/apps/roles'),
                    icon: <IconUserShield size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['roles-access']),
                },
                {
                    title: 'Audit Trail',
                    href: '/apps/audit-trails',
                    active: url.startsWith('/apps/audit-trails'),
                    icon: <IconHistory size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['audit-trails-access']),
                },
                {
                    title: 'Pengguna',
                    icon: <IconUsers size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['users-access']),
                    subdetails: [
                        {
                            title: 'Data Pengguna',
                            href: '/apps/users',
                            icon: <IconAdjustments size={20} strokeWidth={1.5} />,
                            active: url === '/apps/users',
                            permissions: hasAnyPermission(['users-data']),
                        },
                    ],
                },
            ],
        },
    ];

    return menuNavigation;
}
