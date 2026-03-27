import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconChartBarPopular, IconCirclePlus, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { advancedReportingAnalytics } = usePage().props;

    return <><Head title="Advanced Reporting & Analytics" /><div className="mb-3"><Button type="link" href={route('apps.advanced-reporting-analytics.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Analytics" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconChartBarPopular size={18} strokeWidth={1.5} />Advanced Reporting & Analytics</div>}><Table><Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Judul</Table.Th><Table.Th>Periode</Table.Th><Table.Th>Kategori</Table.Th><Table.Th>Anomali</Table.Th><Table.Th>Akurasi %</Table.Th><Table.Th>Prepared By</Table.Th><Table.Th>Status</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{advancedReportingAnalytics.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.analytics_no}</Table.Td><Table.Td>{item.report_title}</Table.Td><Table.Td>{item.report_period}</Table.Td><Table.Td>{item.metric_category}</Table.Td><Table.Td>{item.anomaly_count}</Table.Td><Table.Td>{item.prediction_accuracy}</Table.Td><Table.Td>{item.prepared_by_name ?? '-'}</Table.Td><Table.Td>{item.status}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.advanced-reporting-analytics.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.advanced-reporting-analytics.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
