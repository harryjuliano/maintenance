import Card from '@/Components/Card';
import Table from '@/Components/Table';
import Widget from '@/Components/Widget';
import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import {
    IconAlertTriangle,
    IconChartBar,
    IconClipboardList,
    IconHistory,
    IconLayoutDashboard,
    IconTool,
} from '@tabler/icons-react';
import { ArcElement, CategoryScale, Chart as ChartJS, Legend, LinearScale, Title, Tooltip } from 'chart.js';
import { Doughnut } from 'react-chartjs-2';

ChartJS.register(CategoryScale, LinearScale, ArcElement, Title, Tooltip, Legend);

export default function Dashboard() {
    const { summary, statusChart, breakdownTrend, recentAudits } = usePage().props;

    const orderStatusChart = {
        labels: statusChart.map((item) => item.status),
        datasets: [{
            label: 'Work Orders',
            data: statusChart.map((item) => item.total),
            backgroundColor: ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#14b8a6', '#8b5cf6'],
        }],
    };

    return (
        <>
            <Head title="Dashboard Dasar" />

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <Widget title="Asset Aktif" subtitle="Mesin siap operasi" color="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200" icon={<IconLayoutDashboard size={20} strokeWidth={1.5} />} total={summary.active_assets} />
                <Widget title="Open Work Order" subtitle="Backlog saat ini" color="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200" icon={<IconTool size={20} strokeWidth={1.5} />} total={summary.open_work_orders} />
                <Widget title="Work Request Aktif" subtitle="Submitted/Reviewed/Approved" color="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200" icon={<IconClipboardList size={20} strokeWidth={1.5} />} total={summary.submitted_work_requests} />
                <Widget title="Breakdown Open" subtitle="Belum closed/converted" color="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200" icon={<IconAlertTriangle size={20} strokeWidth={1.5} />} total={summary.breakdown_open} />
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 mt-5 gap-4 items-start">
                <Card title={<div className="flex items-center gap-2"><IconChartBar size={18} strokeWidth={1.5} />Breakdown Trend (6 bulan)</div>}>
                    <ul className="space-y-2 text-sm">
                        {breakdownTrend.length === 0 && <li className="text-gray-500">Belum ada data breakdown.</li>}
                        {breakdownTrend.map((item) => (
                            <li key={item.month} className="flex justify-between border-b pb-1 border-gray-200 dark:border-gray-800">
                                <span>{item.month}</span>
                                <span className="font-semibold">{item.total}</span>
                            </li>
                        ))}
                    </ul>
                </Card>

                <Card title={<div className="flex items-center gap-2"><IconTool size={18} strokeWidth={1.5} />Komposisi Status WO</div>} className="lg:col-span-2">
                    <div className="max-w-md">
                        <Doughnut data={orderStatusChart} />
                    </div>
                </Card>
            </div>

            <div className="mt-5">
                <Table.Card title={<div className="flex items-center gap-2"><IconHistory size={20} strokeWidth={1.5} />Audit Trail Terbaru</div>}>
                    <Table>
                        <Table.Thead>
                            <tr>
                                <Table.Th>Waktu</Table.Th>
                                <Table.Th>User</Table.Th>
                                <Table.Th>Module</Table.Th>
                                <Table.Th>Action</Table.Th>
                                <Table.Th>Deskripsi</Table.Th>
                            </tr>
                        </Table.Thead>
                        <Table.Tbody>
                            {recentAudits.map((item) => (
                                <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                    <Table.Td>{item.created_at}</Table.Td>
                                    <Table.Td>{item.user_name ?? '-'}</Table.Td>
                                    <Table.Td>{item.module}</Table.Td>
                                    <Table.Td>{item.action}</Table.Td>
                                    <Table.Td>{item.description ?? '-'}</Table.Td>
                                </tr>
                            ))}
                        </Table.Tbody>
                    </Table>
                </Table.Card>
            </div>
        </>
    );
}

Dashboard.layout = (page) => <AppLayout children={page} />;
