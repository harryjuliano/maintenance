import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconChecklist, IconCirclePlus, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { inspectionChecklists } = usePage().props;

    return (
        <>
            <Head title="Inspection Checklist" />
            <div className="mb-3">
                <Button type="link" href={route('apps.inspection-checklists.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Inspection Checklist" variant="gray" />
            </div>
            <Table.Card title={<div className="flex items-center gap-2"><IconChecklist size={18} strokeWidth={1.5} />Inspection Checklist</div>}>
                <Table>
                    <Table.Thead>
                        <tr>
                            <Table.Th>Kode</Table.Th>
                            <Table.Th>Nama</Table.Th>
                            <Table.Th>Asset</Table.Th>
                            <Table.Th>Tipe</Table.Th>
                            <Table.Th>Frekuensi</Table.Th>
                            <Table.Th>Aktif</Table.Th>
                            <Table.Th></Table.Th>
                        </tr>
                    </Table.Thead>
                    <Table.Tbody>
                        {inspectionChecklists.data.map((item) => (
                            <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <Table.Td>{item.code}</Table.Td>
                                <Table.Td>{item.name}</Table.Td>
                                <Table.Td>{item.asset_name ?? '-'}</Table.Td>
                                <Table.Td>{item.inspection_type}</Table.Td>
                                <Table.Td>{item.frequency_value} {item.frequency_unit}</Table.Td>
                                <Table.Td>{item.active ? 'Ya' : 'Tidak'}</Table.Td>
                                <Table.Td>
                                    <div className="flex gap-2">
                                        <Button type="edit" href={route('apps.inspection-checklists.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" />
                                        <Button type="delete" url={route('apps.inspection-checklists.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" />
                                    </div>
                                </Table.Td>
                            </tr>
                        ))}
                    </Table.Tbody>
                </Table>
            </Table.Card>
        </>
    );
}

Index.layout = (page) => <AppLayout children={page} />;
