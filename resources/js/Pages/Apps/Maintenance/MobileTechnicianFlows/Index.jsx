import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconPencilCog, IconTool, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { mobileTechnicianFlows } = usePage().props;

    return <><Head title="Mobile Technician Flow" /><div className="mb-3"><Button type="link" href={route('apps.mobile-technician-flows.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Flow" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconTool size={18} strokeWidth={1.5} />Mobile Technician Flow</div>}><Table><Table.Thead><tr><Table.Th>No Flow</Table.Th><Table.Th>WO</Table.Th><Table.Th>Teknisi</Table.Th><Table.Th>Check-in</Table.Th><Table.Th>Check-out</Table.Th><Table.Th>Status</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{mobileTechnicianFlows.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.flow_no}</Table.Td><Table.Td>{item.wo_no ?? '-'}</Table.Td><Table.Td>{item.technician_name ?? '-'}</Table.Td><Table.Td>{item.checkin_at ?? '-'}</Table.Td><Table.Td>{item.checkout_at ?? '-'}</Table.Td><Table.Td>{item.status}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.mobile-technician-flows.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.mobile-technician-flows.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
