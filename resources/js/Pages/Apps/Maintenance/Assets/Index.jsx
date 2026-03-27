import AppLayout from '@/Layouts/AppLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconPencilCog, IconTool, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { assets } = usePage().props;

    return (
        <>
            <Head title="Asset Master" />
            <div className="mb-3">
                <Button
                    type="link"
                    href={route('apps.assets.create')}
                    icon={<IconCirclePlus size={18} strokeWidth={1.5} />}
                    label="Tambah Asset"
                    variant="gray"
                />
            </div>
            <Table.Card title={<div className="flex items-center gap-2"><IconTool size={18} strokeWidth={1.5} />Asset Master</div>}>
                <Table>
                    <Table.Thead>
                        <tr>
                            <Table.Th>Kode</Table.Th>
                            <Table.Th>Nama</Table.Th>
                            <Table.Th>Nomor Asset</Table.Th>
                            <Table.Th>Criticality</Table.Th>
                            <Table.Th>Strategi</Table.Th>
                            <Table.Th>Status</Table.Th>
                            <Table.Th></Table.Th>
                        </tr>
                    </Table.Thead>
                    <Table.Tbody>
                        {assets.data.map((asset) => (
                            <tr key={asset.id} className="hover:bg-gray-100 dark:hover:bg-gray-900">
                                <Table.Td>{asset.asset_code}</Table.Td>
                                <Table.Td>{asset.asset_name}</Table.Td>
                                <Table.Td>{asset.asset_number}</Table.Td>
                                <Table.Td>{asset.criticality_level}</Table.Td>
                                <Table.Td>{asset.maintenance_strategy}</Table.Td>
                                <Table.Td>{asset.status}</Table.Td>
                                <Table.Td>
                                    <div className="flex gap-2">
                                        <Button type="edit" href={route('apps.assets.edit', asset.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" />
                                        <Button type="delete" url={route('apps.assets.destroy', asset.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" />
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
