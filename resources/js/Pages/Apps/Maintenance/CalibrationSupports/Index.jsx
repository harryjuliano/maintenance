import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconPencilCog, IconRulerMeasure, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { calibrationSupports } = usePage().props;

    return (
        <>
            <Head title="Calibration Support" />
            <div className="mb-3">
                <Button type="link" href={route('apps.calibration-supports.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Calibration Support" variant="gray" />
            </div>
            <Table.Card title={<div className="flex items-center gap-2"><IconRulerMeasure size={18} strokeWidth={1.5} />Calibration Support</div>}>
                <Table>
                    <Table.Thead>
                        <tr>
                            <Table.Th>No Kalibrasi</Table.Th>
                            <Table.Th>Checklist</Table.Th>
                            <Table.Th>Asset</Table.Th>
                            <Table.Th>Jadwal</Table.Th>
                            <Table.Th>Status</Table.Th>
                            <Table.Th>Result</Table.Th>
                            <Table.Th></Table.Th>
                        </tr>
                    </Table.Thead>
                    <Table.Tbody>
                        {calibrationSupports.data.map((item) => (
                            <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <Table.Td>{item.calibration_no}</Table.Td>
                                <Table.Td>{item.checklist_name}</Table.Td>
                                <Table.Td>{item.asset_name ?? '-'}</Table.Td>
                                <Table.Td>{item.scheduled_at}</Table.Td>
                                <Table.Td>{item.status}</Table.Td>
                                <Table.Td>{item.result}</Table.Td>
                                <Table.Td>
                                    <div className="flex gap-2">
                                        <Button type="edit" href={route('apps.calibration-supports.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" />
                                        <Button type="delete" url={route('apps.calibration-supports.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" />
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
