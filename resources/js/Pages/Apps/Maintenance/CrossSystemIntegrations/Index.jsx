import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconPencilCog, IconPlugConnected, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { crossSystemIntegrations } = usePage().props;

    return <><Head title="Integrasi Lintas Sistem" /><div className="mb-3"><Button type="link" href={route('apps.cross-system-integrations.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Integrasi" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconPlugConnected size={18} strokeWidth={1.5} />Integrasi Lintas Sistem</div>}><Table><Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Sistem</Table.Th><Table.Th>Tipe</Table.Th><Table.Th>Frekuensi</Table.Th><Table.Th>Last Sync</Table.Th><Table.Th>Success %</Table.Th><Table.Th>PIC</Table.Th><Table.Th>Status</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{crossSystemIntegrations.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.integration_no}</Table.Td><Table.Td>{item.system_name}</Table.Td><Table.Td>{item.integration_type}</Table.Td><Table.Td>{item.sync_frequency}</Table.Td><Table.Td>{item.last_sync_at ?? '-'}</Table.Td><Table.Td>{item.success_rate_pct}</Table.Td><Table.Td>{item.owner_name ?? '-'}</Table.Td><Table.Td>{item.status}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.cross-system-integrations.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.cross-system-integrations.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
