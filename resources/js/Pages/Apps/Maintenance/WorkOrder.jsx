import Table from '@/Components/Table';
import AppLayout from '@/Layouts/AppLayout';
import { Head } from '@inertiajs/react';
import { IconTool } from '@tabler/icons-react';

const orders = [
    {
        no: 'WO-EMG-260327-01',
        fromRequest: 'WR-260327-001',
        asset: 'Air Compressor A',
        priority: 'Critical',
        planner: 'Raf Planner',
        assigned: 'Team Utility',
        status: 'In Progress',
    },
    {
        no: 'WO-COR-260327-03',
        fromRequest: 'WR-260326-019',
        asset: 'Filler Line PLC',
        priority: 'High',
        planner: 'Ari Planner',
        assigned: 'Team Electrical',
        status: 'Planned',
    },
    {
        no: 'WO-INS-260326-08',
        fromRequest: 'WR-260325-022',
        asset: 'Mixer Tank A',
        priority: 'Medium',
        planner: 'Mira Planner',
        assigned: 'Team Process',
        status: 'Completed',
    },
];

export default function WorkOrder() {
    return (
        <>
            <Head title="Work Order" />

            <div className="space-y-4">
                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4">
                    <h1 className="text-lg font-semibold text-gray-800 dark:text-gray-100">Work Order</h1>
                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Eksekusi pekerjaan maintenance terkontrol dari planning, assignment, hingga completion sebagai fondasi
                        Fase 1.
                    </p>
                </section>

                <Table.Card title={<div className="flex items-center gap-2"><IconTool size={18} strokeWidth={1.5} /> Monitoring Work Order</div>}>
                    <Table>
                        <Table.Thead>
                            <tr>
                                <Table.Th>No WO</Table.Th>
                                <Table.Th>Referensi WR</Table.Th>
                                <Table.Th>Asset</Table.Th>
                                <Table.Th>Prioritas</Table.Th>
                                <Table.Th>Planner</Table.Th>
                                <Table.Th>Assigned Team</Table.Th>
                                <Table.Th>Status</Table.Th>
                            </tr>
                        </Table.Thead>
                        <Table.Tbody>
                            {orders.map((order) => (
                                <tr key={order.no} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                    <Table.Td>{order.no}</Table.Td>
                                    <Table.Td>{order.fromRequest}</Table.Td>
                                    <Table.Td>{order.asset}</Table.Td>
                                    <Table.Td>{order.priority}</Table.Td>
                                    <Table.Td>{order.planner}</Table.Td>
                                    <Table.Td>{order.assigned}</Table.Td>
                                    <Table.Td>{order.status}</Table.Td>
                                </tr>
                            ))}
                        </Table.Tbody>
                    </Table>
                </Table.Card>
            </div>
        </>
    );
}

WorkOrder.layout = (page) => <AppLayout children={page} />;
