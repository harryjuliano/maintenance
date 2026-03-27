import Table from '@/Components/Table';
import AppLayout from '@/Layouts/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { IconBuildingFactory2, IconMapPin } from '@tabler/icons-react';

const assets = [
    {
        code: 'AST-MIX-001',
        name: 'Mixer Tank A',
        category: 'Process Equipment',
        location: 'Plant 1 / Area Mixing',
        criticality: 'Critical',
        strategy: 'Preventive',
        status: 'Active',
    },
    {
        code: 'AST-CMP-014',
        name: 'Air Compressor A',
        category: 'Utility',
        location: 'Plant 1 / Utility Room',
        criticality: 'High',
        strategy: 'Predictive',
        status: 'Under Repair',
    },
    {
        code: 'AST-PLC-027',
        name: 'Filler Line PLC',
        category: 'Automation',
        location: 'Plant 2 / Line 3',
        criticality: 'High',
        strategy: 'Condition Based',
        status: 'Active',
    },
];

export default function AssetMaster() {
    return (
        <>
            <Head title="Asset Master" />

            <div className="space-y-4">
                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4">
                    <h1 className="text-lg font-semibold text-gray-800 dark:text-gray-100">Asset Master</h1>
                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Fase 1 dimulai dari data master aset agar proses Work Request dan Work Order memiliki referensi mesin,
                        lokasi, dan criticality yang konsisten.
                    </p>
                    <div className="mt-3 flex items-center gap-2 text-sm text-sky-700 dark:text-sky-300">
                        <IconMapPin size={16} strokeWidth={1.5} />
                        Mapping aset per plant, area, dan production line.
                    </div>
                </section>

                <Table.Card title={<div className="flex items-center gap-2"><IconBuildingFactory2 size={18} strokeWidth={1.5} /> Daftar Asset Prioritas</div>}>
                    <Table>
                        <Table.Thead>
                            <tr>
                                <Table.Th>Kode</Table.Th>
                                <Table.Th>Nama Asset</Table.Th>
                                <Table.Th>Kategori</Table.Th>
                                <Table.Th>Lokasi</Table.Th>
                                <Table.Th>Criticality</Table.Th>
                                <Table.Th>Strategi</Table.Th>
                                <Table.Th>Status</Table.Th>
                            </tr>
                        </Table.Thead>
                        <Table.Tbody>
                            {assets.map((asset) => (
                                <tr key={asset.code} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                    <Table.Td>{asset.code}</Table.Td>
                                    <Table.Td>{asset.name}</Table.Td>
                                    <Table.Td>{asset.category}</Table.Td>
                                    <Table.Td>{asset.location}</Table.Td>
                                    <Table.Td>{asset.criticality}</Table.Td>
                                    <Table.Td>{asset.strategy}</Table.Td>
                                    <Table.Td>{asset.status}</Table.Td>
                                </tr>
                            ))}
                        </Table.Tbody>
                    </Table>
                </Table.Card>

                <section className="rounded-lg border bg-white dark:bg-gray-950 dark:border-gray-900 p-4 text-sm text-gray-700 dark:text-gray-300">
                    Lanjut ke proses berikutnya:
                    <Link href="/apps/work-requests" className="ml-2 font-semibold text-sky-600 hover:text-sky-500 dark:text-sky-400">
                        Work Request
                    </Link>
                </section>
            </div>
        </>
    );
}

AssetMaster.layout = (page) => <AppLayout children={page} />;
