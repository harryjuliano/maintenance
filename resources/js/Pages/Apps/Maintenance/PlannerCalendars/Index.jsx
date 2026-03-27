import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCalendarDue, IconCirclePlus, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { plannerCalendars } = usePage().props;

    return <><Head title="Planner Calendar" /><div className="mb-3"><Button type="link" href={route('apps.planner-calendars.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Plan" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconCalendarDue size={18} strokeWidth={1.5} />Planner Calendar</div>}><Table><Table.Thead><tr><Table.Th>No Plan</Table.Th><Table.Th>Tanggal</Table.Th><Table.Th>Judul</Table.Th><Table.Th>WO</Table.Th><Table.Th>PIC</Table.Th><Table.Th>Status</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{plannerCalendars.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.plan_no}</Table.Td><Table.Td>{item.plan_date}</Table.Td><Table.Td>{item.title}</Table.Td><Table.Td>{item.wo_no ?? '-'}</Table.Td><Table.Td>{item.assigned_to_name ?? '-'}</Table.Td><Table.Td>{item.status}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.planner-calendars.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.planner-calendars.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
