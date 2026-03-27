import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconBell, IconCirclePlus, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { notifications } = usePage().props;

    return <><Head title="Notification" /><div className="mb-3"><Button type="link" href={route('apps.notifications.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Notification" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconBell size={18} strokeWidth={1.5} />Notification</div>}><Table><Table.Thead><tr><Table.Th>User</Table.Th><Table.Th>Title</Table.Th><Table.Th>Module</Table.Th><Table.Th>Channel</Table.Th><Table.Th>Read At</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{notifications.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.user_name}</Table.Td><Table.Td>{item.title}</Table.Td><Table.Td>{item.module}</Table.Td><Table.Td>{item.channel}</Table.Td><Table.Td>{item.read_at ?? '-'}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.notifications.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.notifications.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
