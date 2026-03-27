import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconPencilCog, IconReportAnalytics, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { kpiReliabilities } = usePage().props;

    return <><Head title="KPI Reliability" /><div className="mb-3"><Button type="link" href={route('apps.kpi-reliabilities.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah KPI" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconReportAnalytics size={18} strokeWidth={1.5} />KPI Reliability</div>}><Table><Table.Thead><tr><Table.Th>Kode</Table.Th><Table.Th>Periode</Table.Th><Table.Th>Asset</Table.Th><Table.Th>MTBF</Table.Th><Table.Th>MTTR</Table.Th><Table.Th>Status</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{kpiReliabilities.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.kpi_code}</Table.Td><Table.Td>{item.kpi_period}</Table.Td><Table.Td>{item.asset_name ?? '-'}</Table.Td><Table.Td>{item.mtbf_hours}</Table.Td><Table.Td>{item.mttr_hours}</Table.Td><Table.Td>{item.status}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.kpi-reliabilities.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.kpi-reliabilities.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
