import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCalendarDue, IconCirclePlus, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { pmSchedulers } = usePage().props;

    return (
        <>
            <Head title="PM Scheduler" />
            <div className="mb-3">
                <Button type="link" href={route('apps.pm-schedulers.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah PM Scheduler" variant="gray" />
            </div>
            <Table.Card title={<div className="flex items-center gap-2"><IconCalendarDue size={18} strokeWidth={1.5} />PM Scheduler</div>}>
                <Table>
                    <Table.Thead>
                        <tr>
                            <Table.Th>Template</Table.Th>
                            <Table.Th>Asset</Table.Th>
                            <Table.Th>Schedule</Table.Th>
                            <Table.Th>Due Date</Table.Th>
                            <Table.Th>Status</Table.Th>
                            <Table.Th></Table.Th>
                        </tr>
                    </Table.Thead>
                    <Table.Tbody>
                        {pmSchedulers.data.map((item) => (
                            <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <Table.Td>{item.template_name ?? '-'}</Table.Td>
                                <Table.Td>{item.asset_name ?? '-'}</Table.Td>
                                <Table.Td>{item.schedule_date}</Table.Td>
                                <Table.Td>{item.due_date}</Table.Td>
                                <Table.Td>{item.status}</Table.Td>
                                <Table.Td>
                                    <div className="flex gap-2">
                                        <Button type="edit" href={route('apps.pm-schedulers.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" />
                                        <Button type="delete" url={route('apps.pm-schedulers.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" />
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
