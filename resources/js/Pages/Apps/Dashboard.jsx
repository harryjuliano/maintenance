import Card from '@/Components/Card';
import Table from '@/Components/Table';
import Widget from '@/Components/Widget';
import AppLayout from '@/Layouts/AppLayout';
import { Head } from '@inertiajs/react';
import {
    IconAlertTriangle,
    IconChecklist,
    IconClockHour4,
    IconEngine,
    IconGauge,
    IconTool,
} from '@tabler/icons-react';
import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Legend,
    LinearScale,
    Title,
    Tooltip,
} from 'chart.js';
import { Bar, Doughnut } from 'react-chartjs-2';

ChartJS.register(CategoryScale, LinearScale, BarElement, ArcElement, Title, Tooltip, Legend);

export default function Dashboard() {
    const breakdownTrend = {
        labels: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
        datasets: [
            {
                label: 'Breakdown',
                data: [21, 17, 14, 11, 7, 5],
                backgroundColor: 'rgba(239, 68, 68, 0.6)',
            },
            {
                label: 'Preventive WO Completed',
                data: [36, 40, 43, 49, 56, 62],
                backgroundColor: 'rgba(34, 197, 94, 0.6)',
            },
        ],
    };

    const issueComposition = {
        labels: ['Mechanical', 'Electrical', 'Instrumentation', 'Utility', 'Others'],
        datasets: [
            {
                label: 'Issue Type',
                data: [42, 28, 12, 11, 7],
                backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6', '#14b8a6', '#8b5cf6'],
            },
        ],
    };

    const highPriorityOrders = [
        { wo: 'WO-EMG-260301', asset: 'Filler Line 2', priority: 'Critical', status: 'In Progress', eta: '26 Mar 2026 14:00' },
        { wo: 'WO-COR-260298', asset: 'Air Compressor A', priority: 'High', status: 'Waiting Spare Part', eta: '26 Mar 2026 16:00' },
        { wo: 'WO-PM-260274', asset: 'Boiler Feed Pump', priority: 'High', status: 'Assigned', eta: '27 Mar 2026 09:00' },
    ];

    const pmDue = [
        { asset: 'Cartoner #3', schedule: '26 Mar 2026', owner: 'Team B', type: 'Weekly PM' },
        { asset: 'Chiller Unit #1', schedule: '27 Mar 2026', owner: 'Team Utility', type: 'Monthly PM' },
        { asset: 'Palletizer #2', schedule: '28 Mar 2026', owner: 'Team C', type: 'Running Hour PM' },
    ];

    return (
        <>
            <Head title="Maintenance Operations Dashboard" />

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <Widget title="Asset Aktif" subtitle="Mesin siap operasi" color="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200" icon={<IconEngine size={20} strokeWidth={1.5} />} total={184} />
                <Widget title="Open Work Order" subtitle="Backlog saat ini" color="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200" icon={<IconTool size={20} strokeWidth={1.5} />} total={37} />
                <Widget title="PM Compliance" subtitle="Realisasi bulan berjalan" color="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200" icon={<IconChecklist size={20} strokeWidth={1.5} />} total={'94.8%'} />
                <Widget title="Downtime (jam)" subtitle="Akumulasi bulan ini" color="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200" icon={<IconClockHour4 size={20} strokeWidth={1.5} />} total={42.6} />
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 mt-5 gap-4 items-start">
                <div className="lg:col-span-2">
                    <div className="p-4 rounded-t-lg border bg-white dark:bg-gray-950 dark:border-gray-900">
                        <div className="flex items-center gap-2 font-semibold text-sm text-gray-700 dark:text-gray-200">
                            <IconGauge size={18} strokeWidth={1.5} /> Trend Breakdown vs Preventive Completion
                        </div>
                    </div>
                    <div className="p-4 rounded-b-lg border border-t-0 bg-white dark:bg-gray-950 dark:border-gray-900">
                        <Bar className="min-w-full" data={breakdownTrend} />
                    </div>
                </div>

                <Card
                    title={
                        <div className="flex items-center gap-2">
                            <IconAlertTriangle size={18} strokeWidth={1.5} /> Komposisi Gangguan
                        </div>
                    }
                    footer={<span className="text-xs text-gray-500">Dominan: Mechanical (42%)</span>}
                >
                    <Doughnut data={issueComposition} />
                </Card>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-2 mt-5 gap-4">
                <Table.Card title="High Priority Work Order" icon={<IconTool size={20} strokeWidth={1.5} />}>
                    <Table>
                        <Table.Thead>
                            <tr>
                                <Table.Th>WO</Table.Th>
                                <Table.Th>Asset</Table.Th>
                                <Table.Th>Prioritas</Table.Th>
                                <Table.Th>Status</Table.Th>
                            </tr>
                        </Table.Thead>
                        <Table.Tbody>
                            {highPriorityOrders.map((item) => (
                                <tr key={item.wo} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                    <Table.Td>{item.wo}</Table.Td>
                                    <Table.Td>{item.asset}</Table.Td>
                                    <Table.Td>{item.priority}</Table.Td>
                                    <Table.Td>{item.status}</Table.Td>
                                </tr>
                            ))}
                        </Table.Tbody>
                    </Table>
                </Table.Card>

                <Table.Card title="PM Due & Reminder" icon={<IconChecklist size={20} strokeWidth={1.5} />}>
                    <Table>
                        <Table.Thead>
                            <tr>
                                <Table.Th>Asset</Table.Th>
                                <Table.Th>Jadwal</Table.Th>
                                <Table.Th>Tipe</Table.Th>
                                <Table.Th>PIC</Table.Th>
                            </tr>
                        </Table.Thead>
                        <Table.Tbody>
                            {pmDue.map((item) => (
                                <tr key={item.asset} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                    <Table.Td>{item.asset}</Table.Td>
                                    <Table.Td>{item.schedule}</Table.Td>
                                    <Table.Td>{item.type}</Table.Td>
                                    <Table.Td>{item.owner}</Table.Td>
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
