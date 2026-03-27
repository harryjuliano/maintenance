import AppLayout from '@/Layouts/AppLayout';
import { Head, Link } from '@inertiajs/react';

const domains = [
    'Asset & Equipment Management',
    'Work Request & Work Order',
    'Preventive / Predictive Maintenance',
    'Breakdown Maintenance',
    'Spare Part & Inventory Control',
    'Inspection, Checklist & Calibration Support',
    'Performance Monitoring & Reporting',
    'Improvement, CAPA & Audit Trail',
];

const phases = [
    {
        title: 'Fase 1 — Foundation',
        items: [
            { label: 'Asset master', href: '/apps/assets', status: 'started' },
            { label: 'Work request', href: '/apps/work-requests', status: 'started' },
            { label: 'Work order', href: '/apps/work-orders', status: 'started' },
            { label: 'Dashboard dasar', status: 'done' },
            { label: 'Role access', status: 'done' },
        ],
    },
    {
        title: 'Fase 2 — Reliability',
        items: [
            { label: 'PM scheduler', href: '/apps/pm-schedulers', status: 'started' },
            { label: 'Inspection checklist', href: '/apps/inspection-checklists', status: 'started' },
            { label: 'Calibration support', href: '/apps/calibration-supports', status: 'started' },
            'Downtime tracking',
            'Spare part control',
            'Notification',
        ],
    },
    {
        title: 'Fase 3 — Continuous Improvement',
        items: ['RCA & CAPA', 'KPI reliability', 'Planner calendar', 'Mobile technician flow', 'Integrasi lintas sistem'],
    },
];

const kpis = [
    'Breakdown count',
    'Downtime hours',
    'MTTR',
    'MTBF',
    'PM compliance',
    'Schedule compliance',
    'Emergency WO ratio',
    'Repeat breakdown rate',
    'Spare part stockout rate',
    'Maintenance cost per asset',
    'Technician utilization',
    'Response time vs SLA',
];

export default function Blueprint() {
    return (
        <>
            <Head title="Maintenance Blueprint" />
            <div className="space-y-4">
                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4">
                    <h1 className="text-lg font-semibold text-gray-800 dark:text-gray-100">Maintenance Operations Blueprint</h1>
                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Refactor starter-kit ini diarahkan untuk kebutuhan harian tim maintenance dengan target zero breakdown,
                        menekankan process approach, risk-based thinking, documented information, performance evaluation,
                        dan continual improvement.
                    </p>
                </section>

                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4">
                    <h2 className="font-semibold text-gray-800 dark:text-gray-100">8 Domain Utama</h2>
                    <ul className="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2 text-sm list-disc list-inside text-gray-700 dark:text-gray-300">
                        {domains.map((domain) => (
                            <li key={domain}>{domain}</li>
                        ))}
                    </ul>
                </section>

                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4">
                    <h2 className="font-semibold text-gray-800 dark:text-gray-100">KPI Prioritas Zero Breakdown</h2>
                    <div className="mt-2 flex flex-wrap gap-2">
                        {kpis.map((kpi) => (
                            <span
                                key={kpi}
                                className="rounded-full px-2.5 py-1 text-xs border border-sky-500/30 bg-sky-500/10 text-sky-700 dark:text-sky-300"
                            >
                                {kpi}
                            </span>
                        ))}
                    </div>
                </section>

                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4">
                    <h2 className="font-semibold text-gray-800 dark:text-gray-100">Roadmap Implementasi</h2>
                    <div className="mt-3 grid grid-cols-1 md:grid-cols-3 gap-3">
                        {phases.map((phase) => (
                            <div key={phase.title} className="border rounded-lg p-3 dark:border-gray-800">
                                <h3 className="text-sm font-semibold text-gray-800 dark:text-gray-100">{phase.title}</h3>
                                <ul className="text-sm mt-2 space-y-1 list-disc list-inside text-gray-700 dark:text-gray-300">
                                    {phase.items.map((item) => (
                                        <li key={typeof item === 'string' ? item : item.label}>
                                            {typeof item === 'string' ? (
                                                item
                                            ) : item.href ? (
                                                <Link href={item.href} className="text-sky-600 hover:text-sky-500 dark:text-sky-400">
                                                    {item.label} {item.status === 'started' ? '(in progress)' : ''}
                                                </Link>
                                            ) : (
                                                `${item.label} ${item.status === 'done' ? '(available)' : ''}`
                                            )}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        ))}
                    </div>
                </section>
            </div>
        </>
    );
}

Blueprint.layout = (page) => <AppLayout children={page} />;
