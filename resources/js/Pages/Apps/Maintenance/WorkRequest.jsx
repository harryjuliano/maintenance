import Table from '@/Components/Table';
import AppLayout from '@/Layouts/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { IconClipboardList } from '@tabler/icons-react';

const requests = [
    {
        no: 'WR-260327-001',
        date: '27 Mar 2026',
        asset: 'Air Compressor A',
        type: 'Breakdown',
        urgency: 'Emergency',
        title: 'Compressor trip berulang',
        status: 'Reviewed',
    },
    {
        no: 'WR-260327-004',
        date: '27 Mar 2026',
        asset: 'Mixer Tank A',
        type: 'Abnormality',
        urgency: 'Medium',
        title: 'Vibrasi meningkat di shaft',
        status: 'Submitted',
    },
    {
        no: 'WR-260326-019',
        date: '26 Mar 2026',
        asset: 'Filler Line PLC',
        type: 'Inspection Followup',
        urgency: 'High',
        title: 'Alarm I/O intermittence',
        status: 'Approved',
    },
];

export default function WorkRequest() {
    return (
        <>
            <Head title="Work Request" />

            <div className="space-y-4">
                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4">
                    <h1 className="text-lg font-semibold text-gray-800 dark:text-gray-100">Work Request</h1>
                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Gerbang permintaan pekerjaan maintenance dari produksi, utility, dan facility untuk ditriase sebelum
                        dikonversi menjadi Work Order.
                    </p>
                </section>

                <Table.Card title={<div className="flex items-center gap-2"><IconClipboardList size={18} strokeWidth={1.5} /> Antrian Work Request</div>}>
                    <Table>
                        <Table.Thead>
                            <tr>
                                <Table.Th>No Request</Table.Th>
                                <Table.Th>Tanggal</Table.Th>
                                <Table.Th>Asset</Table.Th>
                                <Table.Th>Tipe</Table.Th>
                                <Table.Th>Urgency</Table.Th>
                                <Table.Th>Judul</Table.Th>
                                <Table.Th>Status</Table.Th>
                            </tr>
                        </Table.Thead>
                        <Table.Tbody>
                            {requests.map((request) => (
                                <tr key={request.no} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                    <Table.Td>{request.no}</Table.Td>
                                    <Table.Td>{request.date}</Table.Td>
                                    <Table.Td>{request.asset}</Table.Td>
                                    <Table.Td>{request.type}</Table.Td>
                                    <Table.Td>{request.urgency}</Table.Td>
                                    <Table.Td>{request.title}</Table.Td>
                                    <Table.Td>{request.status}</Table.Td>
                                </tr>
                            ))}
                        </Table.Tbody>
                    </Table>
                </Table.Card>

                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4 text-sm text-gray-700 dark:text-gray-300">
                    Setelah review dan approval, request dikonversi ke
                    <Link href="/apps/work-orders" className="ml-2 font-semibold text-sky-600 hover:text-sky-500 dark:text-sky-400">
                        Work Order
                    </Link>
                    .
                </section>
            </div>
        </>
    );
}

WorkRequest.layout = (page) => <AppLayout children={page} />;
