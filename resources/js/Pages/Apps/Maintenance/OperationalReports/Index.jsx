import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconPencilCog, IconReportAnalytics, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { operationalReports } = usePage().props;

    return <><Head title="Reporting Operasional" /><div className="mb-3"><Button type="link" href={route('apps.operational-reports.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Laporan" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconReportAnalytics size={18} strokeWidth={1.5} />Reporting Operasional Dasar</div>}><Table><Table.Thead><tr><Table.Th>No Laporan</Table.Th><Table.Th>Tanggal</Table.Th><Table.Th>Shift</Table.Th><Table.Th>Downtime</Table.Th><Table.Th>Breakdown</Table.Th><Table.Th>PM %</Table.Th><Table.Th>Status</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{operationalReports.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.report_no}</Table.Td><Table.Td>{item.report_date}</Table.Td><Table.Td>{item.shift}</Table.Td><Table.Td>{item.downtime_minutes}</Table.Td><Table.Td>{item.breakdown_count}</Table.Td><Table.Td>{item.pm_compliance}</Table.Td><Table.Td>{item.status}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.operational-reports.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.operational-reports.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
