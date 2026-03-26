import { usePage } from '@inertiajs/react';
import {
    IconActivityHeartbeat,
    IconAdjustments,
    IconBuildingFactory2,
    IconCalendarDue,
    IconClipboardList,
    IconLayout2,
    IconPackages,
    IconReportAnalytics,
    IconRouteAltLeft,
    IconTool,
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
            permissions: hasAnyPermission(['dashboard-access']),
            details: [
                {
                    title: 'Work Request',
                    href: '/apps/dashboard',
                    active: false,
                    icon: <IconClipboardList size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
                },
                {
                    title: 'Work Order',
                    href: '/apps/dashboard',
                    active: false,
                    icon: <IconTool size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
                },
                {
                    title: 'Preventive Maintenance',
                    href: '/apps/dashboard',
                    active: false,
                    icon: <IconCalendarDue size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
                },
                {
                    title: 'Assets & Reliability',
                    href: '/apps/dashboard',
                    active: false,
                    icon: <IconBuildingFactory2 size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
                },
                {
                    title: 'Spare Part Control',
                    href: '/apps/dashboard',
                    active: false,
                    icon: <IconPackages size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
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
                    href: '/apps/dashboard',
                    active: false,
                    icon: <IconReportAnalytics size={20} strokeWidth={1.5} />,
                    permissions: hasAnyPermission(['dashboard-access']),
                },
            ],
        },
        {
            title: 'Administration',
            permissions: hasAnyPermission(['permissions-access']) || hasAnyPermission(['roles-access']) || hasAnyPermission(['users-access']),
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
