import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconPencilCog, IconTool, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { workOrders } = usePage().props;

    return (
        <>
            <Head title="Work Order" />
            <div className="mb-3">
                <Button type="link" href={route('apps.work-orders.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Work Order" variant="gray" />
            </div>
            <Table.Card title={<div className="flex items-center gap-2"><IconTool size={18} strokeWidth={1.5} />Work Order</div>}>
                <Table>
                    <Table.Thead>
                        <tr>
                            <Table.Th>No WO</Table.Th>
                            <Table.Th>No WR</Table.Th>
                            <Table.Th>Asset</Table.Th>
                            <Table.Th>Tipe</Table.Th>
                            <Table.Th>Priority</Table.Th>
                            <Table.Th>Status</Table.Th>
                            <Table.Th></Table.Th>
                        </tr>
                    </Table.Thead>
                    <Table.Tbody>
                        {workOrders.data.map((item) => (
                            <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <Table.Td>{item.work_order_no}</Table.Td>
                                <Table.Td>{item.request_no ?? '-'}</Table.Td>
                                <Table.Td>{item.asset_name ?? '-'}</Table.Td>
                                <Table.Td>{item.work_order_type}</Table.Td>
                                <Table.Td>{item.priority_level}</Table.Td>
                                <Table.Td>{item.status}</Table.Td>
                                <Table.Td>
                                    <div className="flex gap-2">
                                        <Button type="edit" href={route('apps.work-orders.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" />
                                        <Button type="delete" url={route('apps.work-orders.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" />
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
