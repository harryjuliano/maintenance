import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconClockPause, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { downtimeTrackings } = usePage().props;

    return (
        <>
            <Head title="Downtime Tracking" />
            <div className="mb-3">
                <Button type="link" href={route('apps.downtime-trackings.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Downtime" variant="gray" />
            </div>
            <Table.Card title={<div className="flex items-center gap-2"><IconClockPause size={18} strokeWidth={1.5} />Downtime Tracking</div>}>
                <Table>
                    <Table.Thead><tr><Table.Th>WO</Table.Th><Table.Th>Asset</Table.Th><Table.Th>Start</Table.Th><Table.Th>End</Table.Th><Table.Th>Type</Table.Th><Table.Th>Menit</Table.Th><Table.Th></Table.Th></tr></Table.Thead>
                    <Table.Tbody>
                        {downtimeTrackings.data.map((item) => (
                            <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <Table.Td>{item.work_order_no}</Table.Td><Table.Td>{item.asset_name}</Table.Td><Table.Td>{item.downtime_start_at}</Table.Td><Table.Td>{item.downtime_end_at ?? '-'}</Table.Td><Table.Td>{item.downtime_type}</Table.Td><Table.Td>{item.total_minutes ?? '-'}</Table.Td>
                                <Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.downtime-trackings.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.downtime-trackings.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td>
                            </tr>
                        ))}
                    </Table.Tbody>
                </Table>
            </Table.Card>
        </>
    );
}

Index.layout = (page) => <AppLayout children={page} />;
