import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconActivityHeartbeat, IconCirclePlus, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { rcaCapas } = usePage().props;

    return <><Head title="RCA & CAPA" /><div className="mb-3"><Button type="link" href={route('apps.rca-capas.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah RCA/CAPA" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconActivityHeartbeat size={18} strokeWidth={1.5} />RCA & CAPA</div>}><Table><Table.Thead><tr><Table.Th>No RCA</Table.Th><Table.Th>WO</Table.Th><Table.Th>Owner</Table.Th><Table.Th>Due Date</Table.Th><Table.Th>Status</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{rcaCapas.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.rca_no}</Table.Td><Table.Td>{item.wo_no ?? '-'}</Table.Td><Table.Td>{item.owner_name ?? '-'}</Table.Td><Table.Td>{item.due_date ?? '-'}</Table.Td><Table.Td>{item.status}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.rca-capas.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.rca-capas.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
