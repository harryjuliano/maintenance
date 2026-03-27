import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconPackages, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { spareParts } = usePage().props;

    return (
        <>
            <Head title="Spare Part Control" />
            <div className="mb-3"><Button type="link" href={route('apps.spare-parts.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Spare Part" variant="gray" /></div>
            <Table.Card title={<div className="flex items-center gap-2"><IconPackages size={18} strokeWidth={1.5} />Spare Part Control</div>}>
                <Table><Table.Thead><tr><Table.Th>Kode</Table.Th><Table.Th>Nama</Table.Th><Table.Th>Kategori</Table.Th><Table.Th>Min/Max</Table.Th><Table.Th>ROP</Table.Th><Table.Th>Active</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{spareParts.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.part_code}</Table.Td><Table.Td>{item.part_name}</Table.Td><Table.Td>{item.category_name}</Table.Td><Table.Td>{item.min_stock} / {item.max_stock}</Table.Td><Table.Td>{item.reorder_point}</Table.Td><Table.Td>{item.active ? 'Yes' : 'No'}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.spare-parts.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.spare-parts.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table>
            </Table.Card>
        </>
    );
}

Index.layout = (page) => <AppLayout children={page} />;
