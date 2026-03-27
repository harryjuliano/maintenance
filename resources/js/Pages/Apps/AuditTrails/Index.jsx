import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import Search from '@/Components/Search';
import { IconHistory, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { auditTrails } = usePage().props;

    return (
        <>
            <Head title="Audit Trail" />
            <div className="mb-3 w-full md:w-4/12">
                <Search url={route('apps.audit-trails.index')} placeholder="Cari module/action/user..." />
            </div>
            <Table.Card title={<div className="flex items-center gap-2"><IconHistory size={18} strokeWidth={1.5} />Audit Trail Dasar</div>}>
                <Table>
                    <Table.Thead>
                        <tr>
                            <Table.Th>Waktu</Table.Th>
                            <Table.Th>User</Table.Th>
                            <Table.Th>Module</Table.Th>
                            <Table.Th>Action</Table.Th>
                            <Table.Th>Deskripsi</Table.Th>
                            <Table.Th></Table.Th>
                        </tr>
                    </Table.Thead>
                    <Table.Tbody>
                        {auditTrails.data.map((item) => (
                            <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <Table.Td>{item.created_at}</Table.Td>
                                <Table.Td>{item.user_name ?? '-'}</Table.Td>
                                <Table.Td>{item.module}</Table.Td>
                                <Table.Td>{item.action}</Table.Td>
                                <Table.Td>{item.description ?? '-'}</Table.Td>
                                <Table.Td>
                                    <Button type="delete" url={route('apps.audit-trails.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" />
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
