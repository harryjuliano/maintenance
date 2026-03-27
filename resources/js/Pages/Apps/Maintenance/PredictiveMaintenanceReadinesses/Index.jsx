import AppLayout from '@/Layouts/AppLayout';
import { Head, usePage } from '@inertiajs/react';
import Table from '@/Components/Table';
import Button from '@/Components/Button';
import { IconCirclePlus, IconCpu, IconPencilCog, IconTrash } from '@tabler/icons-react';

export default function Index() {
    const { predictiveMaintenanceReadinesses } = usePage().props;

    return <><Head title="Predictive Maintenance Readiness" /><div className="mb-3"><Button type="link" href={route('apps.predictive-maintenance-readinesses.create')} icon={<IconCirclePlus size={18} strokeWidth={1.5} />} label="Tambah Readiness" variant="gray" /></div><Table.Card title={<div className="flex items-center gap-2"><IconCpu size={18} strokeWidth={1.5} />Predictive Maintenance Readiness</div>}><Table><Table.Thead><tr><Table.Th>No</Table.Th><Table.Th>Tanggal</Table.Th><Table.Th>Asset</Table.Th><Table.Th>Data %</Table.Th><Table.Th>Sensor %</Table.Th><Table.Th>Model</Table.Th><Table.Th>Level</Table.Th><Table.Th>Status</Table.Th><Table.Th></Table.Th></tr></Table.Thead><Table.Tbody>{predictiveMaintenanceReadinesses.data.map((item) => <tr key={item.id} className="hover:bg-gray-100 dark:hover:bg-gray-900"><Table.Td>{item.readiness_no}</Table.Td><Table.Td>{item.assessment_date}</Table.Td><Table.Td>{item.asset_name ?? '-'}</Table.Td><Table.Td>{item.data_quality_score}</Table.Td><Table.Td>{item.sensor_coverage_pct}</Table.Td><Table.Td>{item.failure_model_status}</Table.Td><Table.Td>{item.readiness_level}</Table.Td><Table.Td>{item.status}</Table.Td><Table.Td><div className="flex gap-2"><Button type="edit" href={route('apps.predictive-maintenance-readinesses.edit', item.id)} icon={<IconPencilCog size={16} strokeWidth={1.5} />} variant="orange" /><Button type="delete" url={route('apps.predictive-maintenance-readinesses.destroy', item.id)} icon={<IconTrash size={16} strokeWidth={1.5} />} variant="rose" /></div></Table.Td></tr>)}</Table.Tbody></Table></Table.Card></>;
}

Index.layout = (page) => <AppLayout children={page} />;
