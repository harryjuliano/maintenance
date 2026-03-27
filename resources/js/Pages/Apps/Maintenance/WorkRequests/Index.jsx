import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconClipboardList, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { workRequests } = usePage().props;

    return (
        <>
            <Head title="Work Request" />
            <div className="mb-3">
                <Button type="link" href={route('apps.work-requests.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Work Request" variant="gray" />
            </div>
            <Table.Card title={<div className="flex items-center gap-2"><IconClipboardList size={18} strokeWidth={1.5} />Work Request</div>}>
                <Table>
                    <Table.Thead>
                        <tr>
                            <Table.Th>No Request</Table.Th>
                            <Table.Th>Tanggal</Table.Th>
                            <Table.Th>Asset</Table.Th>
                            <Table.Th>Tipe</Table.Th>
                            <Table.Th>Urgency</Table.Th>
                            <Table.Th>Status</Table.Th>
                            <Table.Th></Table.Th>
                        </tr>
                    </Table.Thead>
                    <Table.Tbody>
                        {workRequests.data.map((item) => (
                            <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <Table.Td>{item.request_no}</Table.Td>
                                <Table.Td>{item.request_date}</Table.Td>
                                <Table.Td>{item.asset_name ?? '-'}</Table.Td>
                                <Table.Td>{item.request_type}</Table.Td>
                                <Table.Td>{item.urgency_level}</Table.Td>
                                <Table.Td>{item.status}</Table.Td>
                                <Table.Td>
                                    <div className="flex gap-2">
                                        <Button type="edit" href={route('apps.work-requests.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" />
                                        <Button type="delete" url={route('apps.work-requests.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" />
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
